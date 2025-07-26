<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Support\Facades\DB; // to use DB facade
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10); // Optional: change to ->get() if no pagination
        return view('users.manage-user', compact('users'));
    }
    public function create()
    {
        // Fetch employees - only id as both value and label (as you requested)
        $employees = DB::table('employees')
            ->select('id', 'name')
            ->get();

        // Fetch all branches
        $branches = DB::table('branches')
            ->select('id', 'branch_name')  // assuming branches table has 'name' column
            ->get();

        $roles = DB::table('roles')->select('id', 'name')->get();
        $isAdd = true;
        // Pass data to view
        return view('users.add-user', compact('employees', 'branches', 'roles','isAdd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee'           => 'required|integer',
            'designation'        => 'required|string|max:100',
            'user_name'          => 'required|string|max:255|unique:users,username',
            'first_name'         => 'required|string|max:255',
            'last_name'          => 'nullable|string|max:255',
            'email'              => 'nullable|email|max:255|unique:users,email',
            'mobile_no'          => 'required|string|max:255|unique:users,mobile',
            'back_date'          => 'required|integer|min:0',
            'permission_role'    => 'required|integer|exists:roles,id',
            'branch'             => 'required|integer|exists:branches,id',
            'login_on_holidays'  => 'required|in:0,1',
            'searchable_account' => 'required|in:0,1',
            'user_active'        => 'required|in:0,1',
        ]);
        // Save user
        User::create([
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
            // 'login_on_holidays'   => 0,
            // 'searchable_accounts' => 1,
            // 'user_active'         => 0,
            // 'password'            => Hash::make('123456'),
            'login_on_holidays'   => $validated['login_on_holidays'],
            'searchable_accounts' => $validated['searchable_account'],
            'user_active'         => $validated['user_active'],
            'password'            => Hash::make('123456'),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $decryptedId = base64_decode($id);
        $user = User::with('employees', 'branches', 'roles')->findOrFail($decryptedId);
        $employees = Employee::all();
        $branches = Branch::all();
        $roles = DB::table('roles')->select('id', 'name')->get();

        $show = true;
        return view('users.add-user', compact('user', 'employees', 'branches', 'roles', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $decryptedId = base64_decode($id);
        $user = User::with('employees', 'branches', 'roles')->findOrFail($decryptedId);
        $route = route('user.update', $decryptedId);
        $employees = Employee::all();
        $branches = Branch::all();
        $roles = DB::table('roles')->select('id', 'name')->get();
        $method = 'PUT';

        return view('users.add-user', compact('user', 'employees', 'branches', 'roles', 'method', 'route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $decryptedId = base64_decode($id);
        $user = User::findOrFail($decryptedId);

        $validated = $request->validate([
            'employee'           => 'required|integer',
            'designation'        => 'required|string|max:100',
            'user_name'          => 'required|string|max:255|unique:users,username,' . $user->id,
            'first_name'         => 'required|string|max:255',
            'last_name'          => 'nullable|string|max:255',
            'email'              => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'mobile_no'          => 'required|string|max:255|unique:users,mobile,' . $user->id,
            'back_date'          => 'required|integer|min:0',
            'permission_role'    => 'required|integer|exists:roles,id',
            'branch'             => 'required|integer|exists:branches,id',
            'login_on_holidays'  => 'required|in:0,1',
            'searchable_account' => 'required|in:0,1',
            'user_active'        => 'required|in:0,1',
        ]);

        $user->update([
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

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
