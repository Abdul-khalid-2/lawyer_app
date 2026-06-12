<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->role))
            ->when($request->filled('status'), fn ($q) => $q->where('is_active', $request->status === 'active'))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $roleCounts = [
            'all' => User::count(),
            'super_admin' => User::where('role', 'super_admin')->count(),
            'lawyer' => User::where('role', 'lawyer')->count(),
            'client' => User::where('role', 'client')->count(),
        ];

        return view('dashboard.admin.users.index', compact('users', 'roleCounts'));
    }

    public function toggleStatus(User $user)
    {
        // Never let an admin lock themselves out.
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own account status.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', 'User status updated.');
    }
}
