<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BloodGroup;
use App\Models\Employee;
use App\Models\Member;
use App\Models\PayableExpense;
use App\Models\PayableLedger;
use App\Models\Promotor;
use App\Models\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HRController extends Controller
{
     public function index(Request $request)
     {
          try {
               $query = Employee::with('members', 'branches', 'payableLedgers', 'payableExpenses', 'bloodgroups', 'bankname'); // Eager load member

               if ($request->has('search')) {
                    $search = $request->input('search');

                    $query->where(function ($q) use ($search) {
                         $q->where('member_id', 'like', "%$search%")
                              ->orWhere('name', 'like', "%$search%")
                              ->orWhere('designation', 'like', "%$search%")
                              ->orWhere('gender', 'like', "%$search%")
                              ->orWhere('joining_date', 'like', "%$search%");
                    });
               }

               $employees = $query->orderBy('created_at', 'desc')->paginate(10);
               Log::info($employees);
               return view('employees.manage-employee', compact('employees'));
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }

     public function create()
     {
          try {
               $employee = null;
               $route = route('employee.store');
               $method = 'POST';
               return view('employees.add-employee', compact('employee', 'route', 'method'));
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }
     public function store(Request $request)
     {
          try {
               $request->validate([
                    'member' => 'nullable|integer|exists:members,id',
                    'branch' => 'required|integer',
                    'joining_date' => 'required|date',
                    'gender' => 'required|in:male,female',
                    'dob' => 'required|date',
                    'mobile_no' => 'required|digits:10',
                    'address' => 'nullable|string',
                    'email' => 'nullable|email',
                    'name' => 'required',
                    'designation' => 'nullable'
               ]);

               try {
                    $data['dob'] =  date('Y-m-d', strtotime($request->dob));
                    $data['joining_date'] =  date('Y-m-d', strtotime($request->dob));
               } catch (\Exception $e) {
                    return back()->withErrors(['dob' => 'Invalid date format. Use DD/MM/YYYY.'])->withInput();
               }

               $data['gender'] = $request->gender;
               $data['auto_generate'] = $request->has('auto_generate') ? true : false;

               Employee::create([
                    'name' => $request->name,
                    'designation' => $request->designation,
                    'member_id' => $request->member,
                    'branch_id' => $request->branch,
                    'joining_date' => $data['joining_date'],
                    'gender' => $data['gender'],
                    'dob' => $data['dob'],
                    'email' => $request->email,
                    'mobile_no' => $request->mobile_no,
                    'address' => $request->address,
                    'father_name' => $request->father_name,
                    'pan_no' => $request->pan_no,
                    'aadhar_no' => $request->aadhar_no,
                    'blood_group' => $request->blood_group,
                    'monthly_salary' => $request->monthly_salary,
                    'location' => $request->location,
                    'account_holder' => $request->account_holder,
                    'bank_name' => $request->bank_name,
                    'account_no' => $request->account_no,
                    'ifsc' => $request->ifsc,
                    'nominee_name' => $request->nominee_name,
                    'nominee_relation' => $request->nominee_relation,
                    'nominee_address' => $request->nominee_address,
                    'auto_generate' => $data['auto_generate'],
                    'payable_ledger_id' => $request->payable_ledger,
                    'expense_ledger_id' => $request->expense_ledger,
               ]);

               return redirect()->route('employee.index')->with('success', 'Employee added successfully!');
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }

     public function show($id)
     {
          try {
               $decryptedId = base64_decode($id);
               $employee = Employee::findOrFail($decryptedId);
               $show = true;
               return view('employees.add-employee', compact('employee', 'show'));
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }
     public function edit($id)
     {
          try {
               $decryptedId = base64_decode($id);
               $employee = Employee::findOrFail($decryptedId);
               $route = route('employee.update', $id);
               $method = 'PUT';
               return view('employees.add-employee', compact('employee', 'route', 'method'));
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }
     public function update(Request $request, $id)
     {
          try {
               $decryptedId = base64_decode($id);

               $request->validate([
                    'member' => 'nullable|integer',
                    'branch' => 'required|integer',
                    'joining_date' => 'required|date',
                    'gender' => 'required|in:male,female',
                    'dob' => 'required|date',
                    'mobile_no' => 'required|digits:10',
                    'address' => 'nullable|string',
                    'email' => 'nullable|email',
                    'name' => 'required',
                    'designation' => 'nullable'
               ]);

               try {
                    $data['dob'] = date('Y-m-d', strtotime($request->dob));
                    $data['joining_date'] = date('Y-m-d', strtotime($request->joining_date));
               } catch (\Exception $e) {
                    return back()->withErrors(['dob' => 'Invalid date format. Use DD/MM/YYYY.'])->withInput();
               }

               $employee = Employee::findOrFail($decryptedId);

               $data['gender'] = $request->gender;
               $data['auto_generate'] = $request->has('auto_generate') ? true : false;

               $employee->update([
                    'name' => $request->name,
                    'designation' => $request->designation,
                    'member_id' => $request->member,
                    'branch_id' => $request->branch,
                    'joining_date' => $data['joining_date'],
                    'gender' => $data['gender'],
                    'dob' => $data['dob'],
                    'email' => $request->email,
                    'mobile_no' => $request->mobile_no,
                    'address' => $request->address,
                    'father_name' => $request->father_name,
                    'pan_no' => $request->pan_no,
                    'aadhar_no' => $request->aadhar_no,
                    'blood_group' => $request->blood_group,
                    'monthly_salary' => $request->monthly_salary,
                    'location' => $request->location,
                    'account_holder' => $request->account_holder,
                    'bank_name' => $request->bank_name,
                    'account_no' => $request->account_no,
                    'ifsc' => $request->ifsc,
                    'nominee_name' => $request->nominee_name,
                    'nominee_relation' => $request->nominee_relation,
                    'nominee_address' => $request->nominee_address,
                    'auto_generate' => $data['auto_generate'],
                    'payable_ledger_id' => $request->payable_ledger,
                    'expense_ledger_id' => $request->expense_ledger,
               ]);

               return redirect()->route('employee.index')->with('success', 'Employee updated successfully!');
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }

     public function getRelations()
     {
          try {
               $relations = Relation::all();
               return response()->json($relations);
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          }
     }
     public function getBanks()
     {
          try {
               $banks = Bank::all();
               return response()->json($banks);
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          }
     }
     public function payableExpense()
     {
          try {
               $expenses = PayableExpense::all();
               return response()->json($expenses);
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }
     public function payableLedger()
     {
          try {
               $ledgers = PayableLedger::all();
               return response()->json($ledgers);
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }
     public function bloodGroup()
     {
          try {
               $blood_groups = BloodGroup::all();
               return response()->json($blood_groups);
          } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
               abort(404);
          } 
     }
}
