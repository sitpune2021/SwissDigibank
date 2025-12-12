<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Permissions;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $perPage = $request->input('perPage', 10);
        // $query = Branch::with('state')->orderBy('created_at', 'desc');

        // if ($request->has('search')) {
        //     $search = $request->input('search');
        //     $query->where(function ($q) use ($search) {
        //         $q->where('branch_name', 'like', "%$search%")
        //             ->orWhere('branch_code', 'like', "%$search%")
        //             ->orWhere('city', 'like', "%$search%")
        //             ->orWhere('open_date', 'like', "%$search%")
        //             ->orWhereHas('state', function ($stateQuery) use ($search) {
        //                 $stateQuery->where('name', 'like', "%$search%");
        //             });
        //     });
        // }

        // $branches = $query->paginate($perPage)->appends($request->all());
        return view('roles.manage-permission');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $allPermissions = Permissions::all();
        $menuItems1 = [
            ['title' => 'DASHBOARD'],
            ['title' => 'COMPANY'],
            ['title' => 'USER MANAGEMENT'],
            ['title' => 'COLLECTION CENTERS'],
            ['title' => 'MEMBER MANAGEMENT'],
        ];
        $menuItems2 = [
            ['title' => 'SAVING ACCOUNTS'],
            ['title' => 'FIXED DEPOSITS'],
            ['title' => 'RECURRING DEPOSITS'],
            ['title' => 'GOLD LOAN'],
            ['title' => 'PROPERTY LOAN'],
        ];
        $menuItems3 = [
            ['title' => 'DEPOSIT LOAN'],
            ['title' => 'OTHER LOAN'],
            ['title' => 'FIXED LOAN'],
            ['title' => 'APPROVALS'],
            ['title' => 'PAYMENT COLLECTIONS'],
        ];
        $menuItems4 = [
            ['title' => 'PAYMENT PAYOUTS'],
            ['title' => 'MACHINE COLLECTION'],
            ['title' => 'PASSBOOKS'],
            ['title' => 'PRINT DOCUMENTS'],
            ['title' => 'ADVISORS'],
        ];
        $menuItems5 = [
            ['title' => 'EXTRA SERVICES'],
            ['title' => 'TRANSFER SETTING'],
            ['title' => 'CASHFREE'],
            ['title' => 'ICICI'],
            ['title' => 'WITHIN BANK TRANSFER'],
        ];
        $menuItems6 = [
            ['title' => 'REPORTS'],
            ['title' => 'HR MANAGEMENT'],
            ['title' => 'SOFTWARE SETTINGS'],
            ['title' => 'WEBSITE'],
            ['title' => 'ACCOUNTING'],
        ];
        $menuItems7 = [
            ['title' => 'SMS SCHEDULER'],
            ['title' => 'BUSINESS REPORTS'],
            ['title' => 'DAILY COLLECTION'],
            ['title' => 'AGENT APP'],
            ['title' => 'LOCKERS'],
        ];
        $menuItems8 = [
            ['title' => 'VERIFICATION SUITE'],
            ['title' => 'CIBIL REPORT'],
            ['title' => 'VIEW LEVEL FIELDS PERMISSIONS'],
            ['title' => 'YESBANK'],
            ['title' => 'NOTICE BOARD'],
        ];
        $menuItems9 = [
            ['title' => 'DOWNLOAD REPORTS'],
            ['title' => 'APPOINTMENTS'],
            ['title' => 'INQUIRY'],
            ['title' => 'ENACH'],
            ['title' => 'CC LIMIT'],
        ];
        $menuItems10 = [
            ['title' => 'AXISBANK'],
            ['title' => 'VEHICLE LOAN'],
            ['title' => 'PERSONAL LOAN'],
            ['title' => 'CKYC REPORTS'],
            ['title' => 'PAYLOADS'],

        ];

        return view('roles.add-role', compact(
            'roles',
            'allPermissions',
            'menuItems1',
            'menuItems2',
            'menuItems3',
            'menuItems4',
            'menuItems5',
            'menuItems6',
            'menuItems7',
            'menuItems8',
            'menuItems9',
            'menuItems10'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'role_position' => 'required|string|nullable',
                'permission_type' => 'required|in:admin,agent,both',
                'active' => 'required|in:Yes,No',
                'permissions' => 'nullable|array',
                'permissions.*' => 'string',
            ]);

            Log::info('Storing new role permission', [
                'role_id' => $request->role_id,

                'role_position' => $request->role_position,
                'permission_type' => $request->permission_type,
                'active' => $request->active,
                'permissions' => $request->permissions,
            ]);

            // Save to database
            $rolePermission = RolePermission::create([
                'role_id' => $request->role_id,
                'role_position' => $request->role_position,
                'permission_type' => $request->permission_type,
                'active' => $request->active,
                'permissions' => json_encode([
                    'role_id' => $request->role_id,
                    'permissions' => $request->permissions
                ]), // store as JSON
            ]);
            Log::info('Role permission saved successfully', [
                'id' => $rolePermission->id,
                'role_id' => $rolePermission->role_id,
            ]);

            return redirect()->back()->with('success', 'Role permissions saved successfully!');
        } catch (\Exception $e) {
            // Log any error
            Log::error('Error storing role permission', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Failed to save role permissions.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
