<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', ['users' => User::query()->latest()->paginate(20)]);
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate(['role' => ['required', 'in:user,organizer,admin']]);
        $user->update(['role' => $data['role']]);
        return back()->with('status', 'Role updated.');
    }

    public function toggleBlock(User $user): RedirectResponse
    {
        $user->update(['is_blocked' => !$user->is_blocked]);
        return back()->with('status', 'User status changed.');
    }
}
