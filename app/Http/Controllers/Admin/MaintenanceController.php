<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $requests = \App\Models\MaintenanceRequest::with(['station'])->orderBy('created_at', 'desc')->get();
        return view('admin.maintenance', compact('requests'));
    }
}
