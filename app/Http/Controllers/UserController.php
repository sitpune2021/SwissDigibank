<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Support\Facades\DB; // to use DB facade
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = User::query();

            // Check if there's a search input
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;

                // Add conditions for fields you want to search in
                $query->where(function ($q) use ($search) {
                    $q->where('fname', 'like', "%{$search}%")
                        ->orWhere('lname', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", ["%{$search}%"])
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                });
            }

            $users = $query->orderBy('created_at', 'desc')->paginate(10);
            return view('users.manage-user', compact('users'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
    public function create()
    {
        try {
            $employees = Employee::all();


            $branches = DB::table('branches')
                ->select('id', 'branch_name')  // assuming branches table has 'name' column
                ->get();

            $roles = DB::table('roles')->select('id', 'name')->get();
            $isAdd = true;
            // Pass data to view
            return view('users.add-user', compact('employees', 'branches', 'roles', 'isAdd'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the input data
            $validated = $request->validate([
                'employee'           => 'nullable|integer',
                'designation'        => 'nullable|string|max:100',
                'user_name'          => 'required|string|max:255|unique:users,username',
                'first_name'         => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'last_name'          => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'email'              => 'required|email|max:255|regex:/^[A-Za-z0-9._]+@[^@\s]+\.[A-Za-z]{2,}$/',
                'mobile_no'          => 'required|string|max:10',
                'back_date'          => 'required|integer|min:0',
                'permission_role'    => 'required|integer|exists:roles,id',
                'branch'             => 'required|integer|exists:branches,id',
                'login_on_holidays'  => 'required|in:0,1',
                'searchable_account' => 'required|in:0,1',
                'user_active'        => 'required|in:0,1',
                'name'               => 'nullable',
            ]);

            // Log the validated input data (for debugging purposes)
            Log::info('Validated data:', $validated);

            // Save user
            User::create([
                'name' =>                $validated['first_name'] . ' ' . $validated['last_name'] ?? '',
                'emp_id'               => $validated['employee'],
                'designation'          => $validated['designation'],
                'username'             => $validated['user_name'],
                'fname'                => $validated['first_name'],
                'lname'                => $validated['last_name'],
                'email'                => $validated['email'],
                'mobile'               => $validated['mobile_no'],
                'back_edate_days'      => $validated['back_date'],
                'role_id'              => $validated['permission_role'],
                'branch_id'            => $validated['branch'],
                'login_on_holidays'    => $validated['login_on_holidays'],
                'searchable_accounts'  => $validated['searchable_account'],
                'user_active'          => $validated['user_active'],
                'password'             => Hash::make('123456'),
            ]);

            // Log the success message
            Log::info('User created successfully.');

            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Log the exception if ModelNotFoundException is caught
            Log::error('ModelNotFoundException: ' . $e->getMessage());
            abort(404);
        } catch (\Exception $e) {
            // Log any other exceptions that occur
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Error occurred while creating user.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $decryptedId = base64_decode($id);
            $user = User::with('employees', 'branches', 'roles')->findOrFail($decryptedId);
            $employees = Employee::all();
            $branches = Branch::all();
            $roles = DB::table('roles')->select('id', 'name')->get();

            $show = true;
            return view('users.add-user', compact('user', 'employees', 'branches', 'roles', 'show'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $decryptedId = base64_decode($id);
            $user = User::with('employees', 'branches', 'roles')->findOrFail($decryptedId);
            $route = route('users.update', $decryptedId);
            $employees = Employee::all();
            $branches = Branch::all();
            $roles = DB::table('roles')->select('id', 'name')->get();
            $method = 'PUT';

            return view('users.add-user', compact('user', 'employees', 'branches', 'roles', 'method', 'route'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Decrypt the ID and find the user
            $decryptedId = base64_decode($id);
            $user = User::findOrFail($decryptedId);

            // Log the user being updated
            Log::info('Attempting to update user.', ['user_id' => $user->id, 'user_name' => $user->username]);

            // Validate the incoming request data
            $validated = $request->validate([
                'employee'           => 'nullable|integer',
                'designation'        => 'nullable|string|max:100',
                'user_name'          => 'required|string|max:255,' . $user->id,
                'first_name'         => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'last_name'          => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'email'              => 'required|email|max:255|regex:/^[A-Za-z0-9._]+@[^@\s]+\.[A-Za-z]{2,}$/,' . $user->id,
                'mobile_no'          => 'required|string|max:10,' . $user->id,
                'back_date'          => 'required|integer|min:0',
                'permission_role'    => 'required|integer|exists:roles,id',
                'branch'             => 'required|integer|exists:branches,id',
                'login_on_holidays'  => 'required|in:0,1',
                'searchable_account' => 'required|in:0,1',
                'user_active'        => 'required|in:0,1',
            ]);

            // Log the validated input data for debugging purposes
            Log::info('Validated data for update:', $validated);

            // Update user data
            $user->update([
                'name'                => $validated['first_name'] . ' ' . ($validated['last_name'] ?? ''),
                'emp_id'              => $validated['employee'],
                'designation'         => $validated['designation'],
                'username'            => $validated['user_name'],
                'fname'               => $validated['first_name'],
                'lname'               => $validated['last_name'],
                'email'               => $validated['email'],
                'mobile'              => $validated['mobile_no'],
                'back_edate_days'     => $validated['back_date'],
                'role_id'             => $validated['permission_role'],
                'branch_id'           => $validated['branch'],
                'login_on_holidays'   => $validated['login_on_holidays'],
                'searchable_accounts' => $validated['searchable_account'],
                'user_active'         => $validated['user_active'],
                'password'            => Hash::make('123456'),
            ]);

            // Log success message after update
            Log::info('User updated successfully.', ['user_id' => $user->id]);

            // Redirect with success message
            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Log the error if the user is not found
            Log::error('ModelNotFoundException: User not found for ID: ' . $decryptedId);
            abort(404);
        } catch (\Exception $e) {
            // Log any other errors that may occur
            Log::error('Error updating user: ' . $e->getMessage(), ['user_id' => $decryptedId]);
            return redirect()->route('users.index')->with('error', 'Error occurred while updating user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
