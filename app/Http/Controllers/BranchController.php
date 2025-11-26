<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 10);

            $query = Branch::with(['State'])
                ->where('active', 'Yes')
                ->orderBy('created_at', 'desc');

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
        } catch (\Exception $e) {
            Log::error('Branch index error', ['error' => $e->getMessage()]);
            abort(500, 'Unexpected error while fetching branches');
        }
    }

    public function create()
    {
        try {
            $dynamicOptions = [
                'states' => State::pluck('name', 'id')
            ];
            $formFields = config('branch_form');
            $branch = null;
            $route = route('branch.store');
            $method = 'POST';

            return view('company.branch.add-branch', compact('formFields', 'branch', 'route', 'method', 'dynamicOptions'));
        } catch (\Exception $e) {
            abort(500, 'Unexpected error while preparing form');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'branch_name'      => 'required|string|regex:/^(?=.*[A-Za-z])[A-Za-z0-9\s]+$/',
                'branch_code'      => 'required|string|max:20|unique:branches,branch_code|regex:/^[a-zA-Z][a-zA-Z0-9]*$/',
                'open_date'        => 'required',
                'address_line1' => 'required|string|max:255|regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9\s.,\-\/#]+$/',

                'address_line2' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9\s.,\-\/#]+$/'
                ],

                'ifsc_code'        => 'nullable|string|size:11|regex:/^[A-Za-z0-9]+$/',
                'city'             => 'required|string|max:100',
                'state'            => 'required|integer|exists:states,id',
                'pincode'          => 'required|numeric|digits:6',
                'country'          => 'required|string|max:10|in:India',
                'contact_email'    => 'nullable|email|max:255|regex:/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                'mobile_no'        => 'nullable|digits:10|regex:/^[6-9]\d{9}$/',
                'landline_no'      => 'nullable|string|max:10',
                'gst_no'           => 'nullable|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/',
                'disable_recharge' => 'required|in:yes,no',
                'disable_neft'     => 'required|in:yes,no',
                'permission_letter' => 'nullable|file',
            ]);

            if ($validator->fails()) {
                Log::warning('Branch validation failed', [
                    'errors' => $validator->errors()->toArray(),
                    'input'  => $request->all(),
                ]);

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->except('permission_letter');

            if ($request->hasFile('permission_letter')) {
                $file = $request->file('permission_letter');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('permission_letter', $filename, 'public');
                $data['permission_letter'] = $filePath;
            }

            Branch::create($data);

            return redirect()->route('branch.index')->with('success', 'Branch added successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating branch', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'An unexpected error occurred.')->withInput();
        }
    }

    public function show($id)
    {
        try {
            $decryptedId = base64_decode($id);
            $branch = Branch::with(['State'])->findOrFail($decryptedId);
            $formFields = config('branch_form');
            $dynamicOptions = [
                'states' => State::pluck('name', 'id')
            ];
            $route = '';
            $method = 'POST';
            $show = true;

            return view('company.branch.add-branch', compact('formFields', 'branch', 'route', 'method', 'dynamicOptions', 'id', 'show'));
        } catch (\Exception $e) {
            abort(404, 'Branch not found');
        }
    }

    public function edit($id)
    {
        try {
            $decryptedId = base64_decode($id);
            $branch = Branch::findOrFail($decryptedId);
            $formFields = config('branch_form');
            $dynamicOptions = [
                'states' => State::pluck('name', 'id')
            ];
            $route = route('branch.update', $id);
            $method = 'PUT';

            return view('company.branch.add-branch', compact('formFields', 'branch', 'route', 'method', 'dynamicOptions'));
        } catch (\Exception $e) {
            abort(404, 'Branch not found');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $decryptedId = base64_decode($id);

            $request->validate([
                'branch_name'      => 'required|string|regex:/^(?=.*[A-Za-z])[A-Za-z0-9\s]+$/',
                'branch_code' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^[a-zA-Z][a-zA-Z0-9]*$/',
                    Rule::unique('branches', 'branch_code')->ignore($decryptedId),
                ],
                'open_date'        => 'required',
                'address_line1'    => 'required|string|max:255|regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9\s.,\-\/#]+$/',

                'address_line2' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9\s.,\-\/#]+$/'
                ],

                'ifsc_code'        => 'nullable|string|size:11|regex:/^[A-Za-z0-9]+$/',
                'city'             => 'required|string|max:100',
                'state'            => 'required|integer|exists:states,id',
                'pincode'          => 'required|numeric|digits:6',
                'country'          => 'required|string|max:10|in:India',
                'contact_email'    => 'nullable|email|max:255|regex:/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                'mobile_no'        => 'nullable|digits:10|regex:/^[6-9]\d{9}$/',
                'landline_no'      => 'nullable|string|max:10',
                'gst_no'           => 'nullable|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/',
                'disable_recharge' => 'required|in:yes,no',
                'disable_neft'     => 'required|in:yes,no',
                'permission_letter' => 'nullable|file',
            ]);

            $branch = Branch::findOrFail($decryptedId);

            $data = $request->except('permission_letter');

            // Handle file upload
            if ($request->hasFile('permission_letter')) {

                // delete old file if exists
                if ($branch->permission_letter && Storage::disk('public')->exists($branch->permission_letter)) {
                    Storage::disk('public')->delete($branch->permission_letter);
                }

                $file = $request->file('permission_letter');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('permission_letter', $filename, 'public');
                $data['permission_letter'] = $filePath;
            }

            $branch->update($data);

            return redirect()->route('branch.index')->with('success', 'Branch updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating branch', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->delete();

            return redirect()->route('branch.index')->with('success', 'Branch deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting branch', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete branch.');
        }
    }

    public function getBranches()
    {
        try {
            $branches = Branch::orderBy('id', 'desc')->get();
            return response()->json($branches);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch branches'], 500);
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('q');

        $branches = Branch::where('branch_name', 'like', "%{$search}%")->limit(10)->get();

        return response()->json($branches->map(function ($branch) {
            return [
                'id' => $branch->id,
                'branch_name' => $branch->branch_name,
            ];
        }));
    }
}
