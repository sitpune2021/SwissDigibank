<?php

namespace App\Http\Controllers;


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
            ['title' => 'GOLD LOAN', 'id' => 'gold-loan'],
            ['title' => 'PROPERTY LOAN', 'id' => 'property-loan'],
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
            ['title' => 'FIXED LOAN'],
            ['title' => 'APPROVALS'],
            //['title' => 'MACHINE COLLECTION'],
            ['title' => 'PASSBOOKS'],
            ['title' => 'PRINT DOCUMENTS'],
            ['title' => 'ADVISORS'],
        ];
        $menuItems5 = [
            //['title' => 'EXTRA SERVICES'],
            // ['title' => 'TRANSFER SETTING'],
            // ['title' => 'CASHFREE'],
            // ['title' => 'ICICI'],
            // ['title' => 'WITHIN BANK TRANSFER'],
        ];
        $menuItems6 = [
            ['title' => 'REPORTS'],
            ['title' => 'HR MANAGEMENT'],
            ['title' => 'SOFTWARE SETTINGS'],
            //['title' => 'WEBSITE'],
            ['title' => 'ACCOUNTING'],
        ];
        $menuItems7 = [
            // ['title' => 'SMS SCHEDULER'],
            // ['title' => 'BUSINESS REPORTS'],
            // ['title' => 'DAILY COLLECTION'],
            // ['title' => 'AGENT APP'],
            ['title' => 'LOCKERS'],
        ];
        $menuItems8 = [
            // ['title' => 'VERIFICATION SUITE'],
            // ['title' => 'CIBIL REPORT'],
            // ['title' => 'VIEW LEVEL FIELDS PERMISSIONS'],
            // ['title' => 'YESBANK'],
            ['title' => 'NOTICE BOARD'],
        ];
        $menuItems9 = [
            // ['title' => 'DOWNLOAD REPORTS'],
            // ['title' => 'APPOINTMENTS'],
            // ['title' => 'INQUIRY'],
            // ['title' => 'ENACH'],
        ];
        $menuItems10 = [
            //['title' => 'AXISBANK'],
            ['title' => 'PAYMENT COLLECTIONS'],
            // ['title' => 'PAYMENT PAYOUTS'],
            // ['title' => 'CKYC REPORTS'],
            // ['title' => 'PAYLOADS'],

        ];

        // for add-role.blade.php file feature  add this url for add new tab
        // <!---------------------FIXED LOAN------------------------>
        //  <!-- @include('roles.checkboxes.fixed-loan') -->
        //  <!---------------------PAYMENT PAYOUTS	------------------------>
        //   <!-- @include('roles.checkboxes.payment-payout') -->
        //  <!---------------------MACHINE COLLECTION------------------------>
        //   <!-- @include('roles.checkboxes.machine-col') -->         
        //  <!---------------------EXTRA SERVICES------------------------>
        //  <!-- @include('roles.checkboxes.extra-services') -->
        //  <!---------------------TRANSFER SETTING------------------------>
        //  <!-- @include('roles.checkboxes.transfer-setting') -->
        //  <!---------------------CASHFREE------------------------>
        //  <!-- @include('roles.checkboxes.cashfree') -->
        //  <!--------------------ICICI------------------------>
        //    <!-- @include('roles.checkboxes.icici') -->
        //  <!--------------------WITHIN BANK TRANSFER	------------------------>
        //  <!-- @include('roles.checkboxes.within-bank-trans') -->                                   
        //  <!--------------------WEBSITE------------------------>
        //  <!-- @include('roles.checkboxes.website') -->                                   
        //  <!--------------------	SMS SCHEDULER------------------------>
        //   <!-- @include('roles.checkboxes.sms-scheduler') -->
        //  <!--------------------	BUSINESS REPORTS------------------------>
        //    <!-- @include('roles.checkboxes.bussiness-report') -->
        //  <!--------------------DAILY COLLECTION------------------------>
        //   <!-- @include('roles.checkboxes.daily-collection') -->
        //  <!--------------------AGENT APP------------------------>
        //    <!-- @include('roles.checkboxes.agent-app') -->                                   
        //  <!--------------------VERIFICATION SUITE------------------------>
        //   <!-- @include('roles.checkboxes.verification-suite') -->
        //  <!--------------------CIBIL REPORT------------------------>
        //    <!-- @include('roles.checkboxes.cbil-report') -->
        //  <!--------------------VIEW LEVEL FIELDS PERMISSIONS------------------------>
        //   <!-- @include('roles.checkboxes.view-lavel-field-per') -->
        //  <!--------------------YESBANK------------------------>
        //  <!-- @include('roles.checkboxes.yes-bank') -->                                   
        //  <!--------------------DOWNLOAD REPORTS------------------------>
        //  <!-- @include('roles.checkboxes.download-reports') -->
        //  <!--------------------APPOINTMENTS------------------------>
        //  <!-- @include('roles.checkboxes.appointment') -->
        //  <!--------------------INQUIRY------------------------>
        //    <!-- @include('roles.checkboxes.inquiry') -->
        //  <!--------------------ENACH------------------------>
        //   <!-- @include('roles.checkboxes.enach')  -->
        //  <!--------------------AXISBANK------------------------>
        //   <!-- @include('roles.checkboxes.axis-bank') -->
        //  <!--------------------CKYC REPORTS------------------------>
        //  <!-- @include('roles.checkboxes.ckyc') -->
        //  <!--------------------	PAYLOADS------------------------>
        //  <!-- @include('roles.checkboxes.payload') -->


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

    public function edit($id)
    {
        $rolePermission = RolePermission::with('role')->findOrFail($id);
        $roles = Role::all();
        $allPermissions = Permissions::all();

        $selectedPermissions = $rolePermission->permissions ?? [];

        return view('roles.edit-role', compact(
            'rolePermission',
            'roles',
            'allPermissions',
            'selectedPermissions'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'role_position' => 'nullable|string',
            'permission_type' => 'required|in:admin,agent,both',
            'active' => 'required|in:Yes,No',
            'permissions' => 'nullable|array',
        ]);

        $rolePermission = RolePermission::findOrFail($id);

        $rolePermission->update([
            'role_id' => $request->role_id,
            'role_position' => $request->role_position,
            'permission_type' => $request->permission_type,
            'active' => $request->active,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Role permissions updated successfully!');
    }

    public function show($id)
    {
        $rolePermission = RolePermission::with('role')->findOrFail($id);

        // 🔥 SAME MENU ITEMS LIKE CREATE
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
            ['title' => 'GOLD LOAN', 'id' => 'gold-loan'],
            ['title' => 'PROPERTY LOAN', 'id' => 'property-loan'],
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
            ['title' => 'FIXED LOAN'],
            ['title' => 'APPROVALS'],
            ['title' => 'PASSBOOKS'],
            ['title' => 'PRINT DOCUMENTS'],
            ['title' => 'ADVISORS'],
        ];

        $menuItems5 = [];
        $menuItems6 = [
            ['title' => 'REPORTS'],
            ['title' => 'HR MANAGEMENT'],
            ['title' => 'SOFTWARE SETTINGS'],
            ['title' => 'ACCOUNTING'],
        ];
        $menuItems7 = [
            ['title' => 'LOCKERS'],
        ];
        $menuItems8 = [
            ['title' => 'NOTICE BOARD'],
        ];
        $menuItems9 = [];
        $menuItems10 = [
            ['title' => 'PAYMENT COLLECTIONS'],
        ];

        return view('roles.view-role', compact(
            'rolePermission',
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
        ) + [
            'roles' => Role::all(),
            'selectedPermissions' => $rolePermission->permissions ?? [],
            'readOnly' => true,
        ]);
    }

   
}
