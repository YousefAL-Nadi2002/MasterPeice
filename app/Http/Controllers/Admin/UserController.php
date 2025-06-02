<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)
            ->latest()
            ->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.index')
                ->with('error', 'لا يمكن حذف حساب المشرف');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }

    public function toggleStatus(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.index')
                ->with('error', 'لا يمكن تغيير حالة حساب المشرف');
        }

        $user->update(['is_active' => !$user->is_active]);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تغيير حالة المستخدم بنجاح');
    }
}
