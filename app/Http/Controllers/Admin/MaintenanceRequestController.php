<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        $maintenanceRequests = MaintenanceRequest::with(['station', 'user'])
            ->latest()
            ->paginate(10);
        return view('admin.maintenance.index', compact('maintenanceRequests'));
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        return view('admin.maintenance.show', compact('maintenanceRequest'));
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $maintenanceRequest->update($validated);

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'تم تحديث حالة طلب الصيانة بنجاح');
    }

    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->delete();
        return redirect()->route('admin.maintenance.index')
            ->with('success', 'تم حذف طلب الصيانة بنجاح');
    }
} 