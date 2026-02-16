<?php

namespace App\Http\Controllers;

use App\Models\UnencumberedDeposit;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UnencumberedDepositController extends Controller
{


    public function index()
    {
        $deposite = UnencumberedDeposit::with('bank')->paginate(10);

        return view(
            'company.unencumbered-deposits.index',
            compact('deposite')
        );
    }


    public function create()
    {
        $banks = Bank::orderBy('name')->get();
        $mode = 'create';

        return view('company.unencumbered-deposits.create', compact('banks', 'mode'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'fd_no' => 'required|string|max:100',
            'fd_amount' => 'required|numeric|min:0',
            'annual_interest_rate' => 'required|numeric|min:0|max:100',
            'open_date' => 'required|date',
            'maturity_date' => 'required|date|after_or_equal:open_date',
            'receipt_scan_copy' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'fd_from_deposit_money' => 'nullable|boolean',
        ]);

        if ($request->hasFile('receipt_scan_copy')) {
            $validated['receipt_scan_copy'] =
                $request->file('receipt_scan_copy')->store(
                    'unencumbered-deposits',
                    'public'
                );
        }
        $validated['open_date'] = Carbon::createFromFormat('d-m-Y', $request->open_date)->format('Y-m-d');
        $validated['maturity_date'] = Carbon::createFromFormat('d-m-Y', $request->maturity_date)->format('Y-m-d');

        UnencumberedDeposit::create($validated);

        return redirect()
            ->route('unencumbered-deposits.index')
            ->with('success', 'Unencumbered Deposit created successfully.');
    }

    public function edit(UnencumberedDeposit $unencumberedDeposit)
    {
        $banks = Bank::orderBy('name')->get();
        $mode = 'edit';

        return view(
            'company.unencumbered-deposits.create',
            compact('unencumberedDeposit', 'banks', 'mode')
        );
    }
    public function update(Request $request, UnencumberedDeposit $unencumberedDeposit)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'fd_no' => 'required|string|max:100',
            'fd_amount' => 'required|numeric|min:0',
            'annual_interest_rate' => 'required|numeric|min:0|max:100',
            'open_date' => 'required|date',
            'maturity_date' => 'required|date|after_or_equal:open_date',
            'receipt_scan_copy' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'fd_from_deposit_money' => 'nullable|boolean',
        ]);


        $validated['open_date'] = Carbon::createFromFormat('d-m-Y', $validated['open_date'])->format('Y-m-d');
        $validated['maturity_date'] = Carbon::createFromFormat('d-m-Y', $validated['maturity_date'])->format('Y-m-d');

        if ($request->hasFile('receipt_scan_copy')) {
            if ($unencumberedDeposit->receipt_scan_copy) {
                Storage::disk('public')->delete($unencumberedDeposit->receipt_scan_copy);
            }

            $validated['receipt_scan_copy'] =
                $request->file('receipt_scan_copy')
                    ->store('unencumbered-deposits', 'public');
        }

        $unencumberedDeposit->update($validated);

        return redirect()
            ->route('unencumbered-deposits.index')
            ->with('success', 'Unencumbered Deposit updated successfully.');
    }

    public function show(UnencumberedDeposit $unencumberedDeposit)
    {
        $banks = Bank::orderBy('name')->get();
        $mode = 'show';

        return view(
            'company.unencumbered-deposits.create',
            compact('unencumberedDeposit', 'banks', 'mode')
        );
    }
    public function destroy(string $id)
    {
    }
}
