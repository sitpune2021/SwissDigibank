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
   

    public function index(Request $request)
    {
        $roles = RolePermission::with('role')->latest()->get();

        return view('roles.manage-permission', compact('roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $allPermissions = Permissions::all();
        $menuItems1 = [
            ['title' => 'DASHBOARD'],
            ['title' => 'COMPANY'],
            ['title' => 'USER MANAGEMENT'],
            ['title' => 'COLLECTION CENTERS'],
            ['title' => 'CUSTOMER MANAGEMENT'],
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
            ['title' => 'BUSINESS LOAN'],
            ['title' => 'CC LIMIT'],
            ['title' => 'VEHICLE LOAN'],
        ];
        $menuItems4 = [
            ['title' => 'PERSONAL LOAN'],
            ['title' => 'DAILY WEEKLY'],
            ['title' => 'APPROVALS'],
            //['title' => 'FIXED LOAN'],
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
        ];
        $menuItems10 = [
            ['title' => 'AXISBANK'],
            ['title' => 'PAYMENT COLLECTIONS'],
            ['title' => 'PAYMENT PAYOUTS'],
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
    
    public function store(Request $request)
    {
        try {

            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'role_position' => 'nullable|string',
                'permission_type' => 'required|in:admin,agent,both',
                'active' => 'required|in:Yes,No',
                'permissions' => 'nullable|array',
            ]);

            Log::info('Storing new role permission', [
                'role_id' => $request->role_id,

                'role_position' => $request->role_position,
                'permission_type' => $request->permission_type,
                'active' => $request->active,
                'permissions' => $request->permissions,
            ]);

            // Save to database
            $rolePermission = RolePermission::updateOrCreate(
                ['role_id' => $request->role_id],
                [
                    'role_position'  => $request->role_position,
                    'permission_type'=> $request->permission_type,
                    'active'         => $request->active,
                    'permissions'    => $request->permissions ?? [],
                ]
            );

            Log::info('Role permission saved successfully', [
                'id' => $rolePermission->id,
                'role_id' => $rolePermission->role_id,
            ]);

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role permissions saved successfully!');
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

   
}
