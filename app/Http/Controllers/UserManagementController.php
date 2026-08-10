<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('user-management.index', compact('users'));
    }

    public function edit(User $user)
    {
        $unitKerjaList = config('unitkerja.satker');

        return view('user-management.edit', compact('user', 'unitKerjaList'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['super_admin', 'admin', 'user'])],
            'unit_kerja' => ['nullable', 'string', Rule::in(array_keys(config('unitkerja.satker')))],
            'urusan' => ['nullable', 'string', Rule::in(collect(config('unitkerja.satker'))->flatten()->all())],
        ]);

        $user->update($request->only(['name', 'email', 'role', 'unit_kerja', 'urusan']));

        return redirect()->route('user-management.index')
            ->with('success', "User {$user->name} berhasil diupdate.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('user-management.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('user-management.index')
            ->with('success', "User {$user->name} berhasil dihapus.");
    }
}
