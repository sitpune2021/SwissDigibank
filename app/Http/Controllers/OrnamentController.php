<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanOrnament;
use App\Exports\OrnamentsExport;
use Maatwebsite\Excel\Facades\Excel;


class OrnamentController extends Controller
{
   
    public function index(Request $request)
    {
        $query = LoanOrnament::query()->with('loanApplication');

        if ($request->filled('application_id')) {
            $query->where('application_id', 'LIKE', "%{$request->application_id}%");
        }
        if ($request->filled('item_type')) {
            $query->where('item_type', $request->item_type);
        }
        if ($request->filled('item_name')) {
            $query->where('item_name', 'LIKE', "%{$request->item_name}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sabhi ornaments
        $ornaments = $query->paginate(10)->appends($request->query());

        // Status wise alag alag pagination
        $mortgageItems = LoanOrnament::where('status', '1')
            ->paginate(10, ['*'], 'mortgage_page');

        $releasedItems = LoanOrnament::where('status', '0')
            ->paginate(10, ['*'], 'released_page');

        // Agar AJAX hai to sirf ornaments table bhejo
        if ($request->ajax()) {
            return view('gold-loan.ornaments.table', compact('ornaments'))->render();
        }

        // Normal page load
        return view('gold-loan.ornaments.index', compact('ornaments', 'mortgageItems', 'releasedItems'));
    }

    public function exportXls()
    {
        $fileName = 'ornaments_' . date('Y-m-d') . '.csv';

        $ornaments = LoanOrnament::query()
            ->join('loan_applications', 'loan_applications.id', '=', 'loan_ornaments.application_id')
            ->join('branches', 'branches.id', '=', 'loan_applications.branch_id')
            ->join('members', 'members.id', '=', 'loan_applications.member_id')
            ->select(
                'branches.branch_name as BRANCH_NAME',
                'members.id as MEMBER_NO',
                'members.member_info_first_name as MEMBER_NAME',
                'loan_applications.id as APPLICATION_NO',
                'loan_ornaments.item_type as ITEM_TYPE',
                'loan_ornaments.item_name as ITEM_NAME',
                'loan_ornaments.no_of_items as TOTAL_ITEMS',
                'loan_ornaments.value_per_gram as VALUE_PER_GRAM',
                'loan_ornaments.net_weight as NET_WEIGHT',
                'loan_ornaments.tunch as TUNCH',
                'loan_ornaments.fine_weight as FINE_WEIGHT',
                'loan_ornaments.total_value as TOTAL_VALUE',
                'loan_ornaments.status as STATUS',
                'loan_ornaments.remark as REMARK'
            )
            ->get();

        // Convert to array
        $headers = [
            'BRANCH NAME',
            'MEMBER NO',
            'MEMBER NAME',
            'APPLICATION NO',
            'ITEM TYPE',
            'ITEM NAME',
            'TOTAL ITEMS',
            'VALUE PER GRAM (INR)',
            'NET WEIGHT (gm)',
            'TUNCH (%)',
            'FINE WEIGHT (gm)',
            'TOTAL VALUE (INR)',
            'STATUS',
            'REMARK',
        ];

        // Set headers for download
        $responseHeaders = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        // Stream CSV content
        $callback = function () use ($ornaments, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers); // headings

            // foreach ($ornaments as $row) {
            //     fputcsv($file, $row->toArray());
            // }
            foreach ($ornaments as $row) {
                $statusText = $row->STATUS == 1 ? 'Mortgage' : 'Release';

                fputcsv($file, [
                    $row->BRANCH_NAME,
                    $row->MEMBER_NO,
                    $row->MEMBER_NAME,
                    $row->APPLICATION_NO,
                    $row->ITEM_TYPE,
                    $row->ITEM_NAME,
                    $row->TOTAL_ITEMS,
                    $row->VALUE_PER_GRAM,
                    $row->NET_WEIGHT,
                    $row->TUNCH,
                    $row->FINE_WEIGHT,
                    $row->TOTAL_VALUE,
                    $statusText,      // Converted Status
                    $row->REMARK,
                ]);
            }


            fclose($file);
        };

        return response()->stream($callback, 200, $responseHeaders);
    }

    public function update(Request $request, $id)
    {
        $ornament = LoanOrnament::findOrFail($id);

        // Force integer conversion (prevents 'Released'/'Mortgage' text issues)
        $ornament->status = (int) $request->status;

        $ornament->remark = $request->remark;
        $ornament->save();

        return redirect()->route('gold-loan.ornaments.index')
                        ->with('success', 'Ornament updated successfully!');
    }


}
