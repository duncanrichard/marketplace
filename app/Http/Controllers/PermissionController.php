<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\RolePermission;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = ['user', 'manager', 'master'];
        $permissions = Permission::orderBy('menu')->orderBy('action')->get();
        $rolePermissions = RolePermission::all();

        return view('permissions.index', compact('roles', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request)
    {
        RolePermission::truncate();

        foreach ($request->permissions ?? [] as $role => $permissionIds) {
            foreach (array_keys($permissionIds) as $permissionId) {
                RolePermission::create([
                    'role' => $role,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        return back()->with('success', 'Hak akses berhasil diperbarui.');
    }
}