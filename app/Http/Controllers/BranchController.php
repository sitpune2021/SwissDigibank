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
        $query = Branch::with(['State'])
            ->where('active', 'Yes')->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('branch_name', 'like', "%$search%")
                    ->orWhere('branch_code', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%")
                    ->orWhere('open_date', 'like', "%$search%")
                    ->orWhereHas('State', function ($stateQuery) use ($search) {
                        $stateQuery->where('name', 'like', "%$search%");
                    });
            });
        }

        $branches = $query->paginate($perPage)->appends($request->all());
        return view('company.branch.manage-branch', compact('branches'));
    }
    public function create()
    {
        $dynamicOptions = [
            'states' => State::pluck('name', 'id')
        ];
        $formFields = config('branch_form');
        $branch = null;
        $route = route('branch.store');
        $method = 'POST';
        return view('company.branch.add-branch', compact('formFields', 'branch', 'route', 'method', 'dynamicOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_name'      => 'required|string|max:255',
            'branch_code'      => 'required|string|max:100|unique:branches,branch_code',
            'open_date'        => 'required|date',
            'address_line1'    => 'required|string|max:255',
            'address_line2'    => 'nullable|string|max:255',
            'ifsc_code'        => 'required|string|max:255',
            'city'             => 'required|string|max:100',
            'state'            => 'required|integer|exists:states,id',
            'pincode'          => 'required|numeric|digits_between:4,10',
            'country'          => 'required|string|max:100',
            'contact_email'    => 'required|email|max:255',
            'mobile_no'        => 'nullable|string|max:20',
            'landline_no'      => 'nullable|string|max:20',
            'gst_no'           => 'nullable|string|max:30',
            'disable_recharge' => 'required|in:yes,no',
            'disable_neft'     => 'required|in:yes,no',
        ]);

        try {
            Branch::create($request->all());

            return redirect()->route('branch.index')
                            ->with('success', 'Branch added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! Please try again. Error: ' . $e->getMessage())
                        ->withInput();
        }
    }


    public function show($id)
    {
        $decryptedId = base64_decode($id);
        $dynamicOptions = [
            'states' => State::pluck('name', 'id')
        ];
        $formFields = config('branch_form');
        $branch = Branch::with(['State'])->find($decryptedId);;
        $route = "";
        $method = 'POST';
        $show = true;
        $encryptedId = $id;
        return view('company.branch.add-branch', compact('formFields', 'branch', 'route', 'method', 'dynamicOptions', 'encryptedId', 'show'));
    }
    public function edit($id)
    {
        $decryptedId = base64_decode($id);
        $branch = Branch::findOrFail($decryptedId);
        $dynamicOptions = [
            'states' =>  State::pluck('name', 'id')
        ];
        $formFields = config('branch_form');
        $route = route('branch.update', $id);
        $method = 'PUT';
        return view('company.branch.add-branch', compact('formFields', 'branch', 'route', 'method', 'dynamicOptions'));
    }
    
    public function update(Request $request, $id)
    {
        $decryptedId = base64_decode($id);

        $request->validate([
            'branch_name'      => 'required|string|max:255',
            'branch_code'      => 'required|string|max:100|unique:branches,branch_code,' . $decryptedId,
            'open_date'        => 'required|date',
            'address_line1'    => 'required|string|max:255',
            'address_line2'    => 'nullable|string|max:255',
            'ifsc_code'        => 'required|string|max:255',
            'city'             => 'required|string|max:100',
            'state'            => 'required|integer|exists:states,id',
            'pincode'          => 'required|numeric|digits_between:4,10',
            'country'          => 'required|string|max:100',
            'contact_email'    => 'required|email|max:255',
            'mobile_no'        => 'nullable|string|max:20',
            'landline_no'      => 'nullable|string|max:20',
            'gst_no'           => 'nullable|string|max:30',
            'disable_recharge' => 'required|in:yes,no',
            'disable_neft'     => 'required|in:yes,no',
        ]);
        try {
            $branch = Branch::findOrFail($decryptedId);

            $branch->update($request->only($branch->getFillable()));

            return redirect()->route('branch.index')->with('success', 'Branch updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! Error: ' . $e->getMessage())->withInput();
        }

    }


    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branch.index')->with('success', 'Branch deleted successfully.');
    }
    public function getBranches()
    {
        $branches = Branch::orderBy('id', 'desc')->get();
        return response()->json($branches);
    }
}
