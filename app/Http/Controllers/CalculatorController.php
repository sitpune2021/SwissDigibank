<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FdMaturityStatement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalculatorController extends Controller
{
    private function roundToPrecision($number, $precision = 2)
    {
        return round($number, $precision);
    }

    public function index() {}

    public function create()
    {
        return view('fd_account.calculator.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'open_date' => 'required|date',
            'principal' => 'required|numeric|min:1',
            'rate' => 'required|numeric|min:0',
            'tenure' => 'required|numeric|min:1',
            'tenure_type' => 'required|in:Months,Years',
            'interest_payout' => 'required',
            'bonus_type' => 'nullable|in:%,Fixed',
            'bonus_amount' => 'nullable|numeric|min:0',
        ]);

        $principal = $validated['principal'];
        $rate = $validated['rate'];
        $tenure = $validated['tenure'];
        $tenureType = $validated['tenure_type'];
        $interestPayout = $validated['interest_payout'];
        $bonusType = $validated['bonus_type'] ?? null;
        $bonusAmount = $validated['bonus_amount'] ?? 0;
        $startDate = Carbon::parse($validated['open_date']);
        $tdsRate = 0; // Set to 0 by default as in your screenshot

        // Convert tenure into months
        $totalMonths = $tenureType === 'Years' ? $tenure * 12 : $tenure;

        // Determine payout interval in months
        $intervals = [
            'Monthly' => 1,
            'Quarterly' => 3,
            'Half Yearly' => 6,
            'Yearly' => 12,
        ];

        $compoundingType = strtolower($interestPayout);

        $interestPeriods = [];
        $currentPrincipal = $principal;
        $totalInterest = 0;
        $totalTDS = 0;

        $i = 0;
        $currentDate = clone $startDate;

        while ($i < $totalMonths) {
            // Determine the interval
            $monthsToAdd = match (true) {
                str_contains($compoundingType, 'monthly') => 1,
                str_contains($compoundingType, 'quarterly') => 3,
                str_contains($compoundingType, 'half yearly') => 6,
                str_contains($compoundingType, 'yearly') => 12,
                default => $totalMonths - $i // For "On Maturity"
            };

            $periodStart = $currentDate->copy();
            $periodEnd = $currentDate->copy()->addMonths(min($monthsToAdd, $totalMonths - $i));
            $days = $periodEnd->diffInDays($periodStart);

            $periodRate = ($rate / 100) * ($days / 365);
            $interest = $currentPrincipal * $periodRate;
            $tds = $interest * ($tdsRate / 100);
            $netInterest = $interest - $tds;

            // Compound only for cumulative types
            if (str_contains($compoundingType, 'cumulative') || $compoundingType === 'on maturity') {
                $currentPrincipal += $netInterest;
            }

            $totalInterest += $interest;
            $totalTDS += $tds;

            $interestPeriods[] = [
                'period' => $periodStart->format('d/m/Y') . ' - ' . $periodEnd->format('d/m/Y'),
                'days' => $days,
                'principal' => round($currentPrincipal, 2),
                'interest' => round($interest, 2),
                'tds' => round($tds, 2),
                'net_interest' => round($netInterest, 2),
                'principal_at_eoy' => ($i + $monthsToAdd) % 12 === 0 ? round($currentPrincipal, 2) : null,
                'due_by' => $periodEnd->format('d/m/Y'),
            ];

            $currentDate = $periodEnd;
            $i += $monthsToAdd;
        }

        // Maturity Bonus Calculation
        $maturityBonus = 0;
        if ($bonusType && $bonusAmount > 0) {
            $maturityBonus = $bonusType === '%' 
                ? $principal * ($bonusAmount / 100) 
                : $bonusAmount;
        }

        $totalAmountPayable = $currentPrincipal + $maturityBonus;

        // Store in session
        session([
            'fdStatement' => (object) [
                'principal' => $principal,
                'rate' => $rate,
                'tenure' => $tenure,
                'tenure_type' => $tenureType,
                'interest_payout' => $interestPayout,
                'bonus_type' => $bonusType,
                'bonus_amount' => $bonusAmount,
                'total_interest' => round($totalInterest, 2),
                'total_tds' => round($totalTDS, 2),
                'maturity_bonus' => round($maturityBonus, 2),
                'total_amount_payable' => round($totalAmountPayable, 2),
                'open_date' => $startDate->format('d/m/Y'),
            ],
            'interestPeriods' => $interestPeriods,
        ]);
    
        return redirect()
            ->back()
            ->with('success', 'FD maturity calculated and saved successfully!');
    }

}
