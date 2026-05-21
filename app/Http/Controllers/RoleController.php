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
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('roles.index', $permissions)) {

            abort(403, 'Permission Denied');

        }

        $search = $request->search;

        $roles = RolePermission::with('role')

            ->when($search, function ($query) use ($search) {

                $query->whereHas('role', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");

                })

                ->orWhere('active', 'like', "%{$search}%");

            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('roles.manage-permission', compact('roles'));
    }

    public function create()
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('roles.index', $permissions)) {

            abort(403, 'Permission Denied');

        }

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
                'title' => 'USER MANAGEMENT',
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
            [
                'title' => 'SAVING / CURRENT ACCOUNTS',
                'id' => 'savin_current_account'
            ],
            [
                'title' => 'FD / MIS MANAGEMENT',
                'id' => 'fd_mis_account'
            ],
            [
                'title' => 'RD / DD MANAGEMENT',
                'id' => 'rd_dd_account'
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
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('roles.edit', $permissions)) {

            abort(403, 'Permission Denied');

        }

        $rolePermission = RolePermission::with('role')->findOrFail($id);

        $roles = Role::where('id', '!=', 1)->get();

        $selectedPermissions = $rolePermission->permissions ?? [];
            //dd($rolePermission->permissions);
        // SAME AS CREATE PAGE
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

        return view('roles.edit-role', compact(

            'rolePermission',
            'roles',
            'selectedPermissions',
            'menuItems'

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
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('roles.show', $permissions)) {

            abort(403, 'Permission Denied');

        }

        $rolePermission = RolePermission::with('role')->findOrFail($id);

        $roles = Role::where('id', '!=', 1)->get();

        $selectedPermissions = $rolePermission->permissions ?? [];

        // SAME AS CREATE & EDIT
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

        return view('roles.view-role', compact(

            'rolePermission',
            'roles',
            'selectedPermissions',
            'menuItems'

        ));
    }

   
}
