<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::where('is_admin', false)
            ->withCount(['bookings'])
            ->get();
        return view('admin.users', compact('users'));
    }
}
