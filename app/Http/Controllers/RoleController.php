<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Permissions;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
   

    public function index(Request $request)
    {
        $roles = RolePermission::with('role')->latest()->get();

        return view('roles.manage-permission', compact('roles'));
    }

    public function create()
    {
        //$roles = Role::all();
        $roles = Role::where('id', '!=', 1)->get();

        $menuItems = [
            [
                'title' => 'DASHBOARD',
                'id' => 'dashboardSection'
            ],
            [
                'title' => 'COMPANY',
                'id' => 'companySection'
            ],
            [
                'title' => 'USER',
                'id' => 'userSection'
            ],
            [
                'title' => 'COLLECTION CENTER',
                'id' => 'collectionCenter'
            ],
            [
                'title' => 'CUSTOMER MANAGEMENT',
                'id' => 'customer'
            ],
        ];

        return view('roles.add-role', compact(
            'roles',
            'menuItems'
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
        ]);

        RolePermission::updateOrCreate(
            ['role_id' => $request->role_id],
            [
                'role_position'   => $request->role_position,
                'permission_type' => $request->permission_type,
                'active'          => $request->active,
                'permissions'     => $request->permissions ?? [],
            ]
        );

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role permissions saved successfully!');

    } catch (ValidationException $e) {

        // IMPORTANT
        throw $e;

    } catch (\Exception $e) {

        Log::error('Error storing role permission', [
            'message' => $e->getMessage(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Failed to save role permissions.');
    }
    }

    public function edit($id)
    {
    $rolePermission = RolePermission::with('role')->findOrFail($id);
    $roles = Role::all();
    $allPermissions = Permissions::all();

    $selectedPermissions = $rolePermission->permissions ?? [];

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

    return view('roles.edit-role', compact(
        'rolePermission',
        'roles',
        'allPermissions',
        'selectedPermissions',
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
