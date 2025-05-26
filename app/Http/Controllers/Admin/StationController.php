<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        $stations = \App\Models\Station::all();
        return view('admin.stations', compact('stations'));
    }
}
