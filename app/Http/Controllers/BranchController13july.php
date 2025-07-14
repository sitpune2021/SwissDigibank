<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\State;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Branch::with('stateData')->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('branch_name', 'like', "%$search%")
                    ->orWhere('branch_code', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%")
                    ->orWhere('open_date', 'like', "%$search%")
                    ->orWhereHas('stateData', function ($stateQuery) use ($search) {
                        $stateQuery->where('name', 'like', "%$search%");
                    });
            });
        }

        $branches = $query->paginate($perPage)->appends($request->all());
        return view('branch.manage-branch', compact('branches'));
    }
    public function create()
    {
        return view('branch.add-branch');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'branch_name' => 'required|string|max:255',
                'branch_code' => 'required|string|max:100|unique:branches,branch_code',
                'open_date' => 'required|date',
                'address_line1' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'pincode' => 'required|numeric',
                'country' => 'required|string|max:100',
                'contact_email' => 'required|email',
                'mobile_no' => 'nullable|string|max:20',
                'landline_no' => 'nullable|string|max:20',
                'gst_no' => 'nullable|string|max:30',
                'disable_recharge' => 'required|in:yes,no',
                'disable_neft' => 'required|in:yes,no',
            ]
            
        );

        try {
$data = $request->all();
 if ($request->filled('open_date')) {
            $data['open_date'] = date('Y-m-d', strtotime($request->input('open_date')));
        }
            Branch::create($data);

            return redirect()->route('manage.branch')->with('success', 'Branch added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! Please try again. Error: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $branch = Branch::with(['stateData'])->find($id);
        return view('branch.view-branch', compact('branch'));
    }
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $states = State::all();

        return view('branch.edit-branch', compact('branch', 'states'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'branch_name' => 'nullable|string|max:255',
                'branch_code' => 'required|string|max:100|unique:branches,branch_code,' . $id,
                'open_date' => 'required|date',
                'address_line1' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'pincode' => 'required|numeric',
                'country' => 'required|string|max:100',
                'contact_email' => 'required|nullable|email',
                'mobile_no' => 'nullable|string|max:20',
                'landline_no' => 'nullable|string|max:20',
                'gst_no' => 'nullable|string|max:30',
                'disable_recharge' => 'required|in:yes,no',
                'disable_neft' => 'required|in:yes,no',
            ],
            [
                'branch_code.required' => 'Branch Code is required.',
                'branch_code.unique' => 'Branch Code already exists.',
                'open_date.required' => 'Open Date is required.',
                'open_date.date' => 'Please enter a valid date.',
                'address_line1.required' => 'Address Line 1 is required.',
                'city.required' => 'City is required.',
                'state.required' => 'State is required.',
                'pincode.required' => 'Pincode is required.',
                'pincode.numeric' => 'Pincode must be a number.',
                'country.required' => 'Country is required.',
                'contact_email.email' => 'Please enter a valid email address.',
                'disable_recharge.required' => 'Please select Yes or No for Disable Recharge/Bill Payment Service.',
                'disable_recharge.in' => 'Invalid option for Disable Recharge.',
                'disable_neft.required' => 'Please select Yes or No for Disable NEFT/IMPS/WITHIN Transfer Service.',
                'disable_neft.in' => 'Invalid option for Disable NEFT.',
            ]
        );

        try {
            $branch = Branch::findOrFail($id);

            $branch->update([
                'branch_name' => $request->branch_name,
                'branch_code' => $request->branch_code,
                'open_date' => date('Y-m-d', strtotime($request->open_date)),
                'ifsc_code' => $request->ifsc_code,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'country' => $request->country,
                'contact_email' => $request->contact_email,
                'mobile_no' => $request->mobile_no,
                'landline_no' => $request->landline_no,
                'gst_no' => $request->gst_no,
                'disable_recharge' => $request->disable_recharge,
                'disable_neft' => $request->disable_neft,
            ]);

            return redirect()->route('manage.branch')->with('success', 'Branch updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('manage.branch')->with('success', 'Branch deleted successfully.');
    }

    public function getBranches()
    {
        $branches = Branch::orderBy('id', 'desc')->get();
        return response()->json($branches);
    }
}
