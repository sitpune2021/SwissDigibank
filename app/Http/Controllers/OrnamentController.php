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
        return Excel::download(new OrnamentsExport, 'ornaments.xlsx');
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
