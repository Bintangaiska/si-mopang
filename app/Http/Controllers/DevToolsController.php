<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevToolsController extends Controller
{
    public function switchRole(Request $request, $role)
    {
        $allowedRoles = ['super_admin', 'admin', 'user'];

        if (!in_array($role, $allowedRoles)) {
            abort(404);
        }

        $user = $request->user();
        $user->role = $role;
        $user->save();

        return redirect()->route('dashboard')->with('success', "Role berhasil diganti ke: {$role}");
    }
}