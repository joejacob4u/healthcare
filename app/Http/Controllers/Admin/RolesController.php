<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $roles = Role::get();
        return view('admin.roles.index', ['roles' => $roles]);
    }

    public function showPermissions(Role $role)
    {
        return view('admin.roles.permissions', ['role' => $role]);
    }

    public function savePermissions(Request $request, Role $role)
    {
        if ($role->update(['permissions' => $request->permissions])) {
            return back()->with('success', 'Permissions saved!');
        }
    }
}
