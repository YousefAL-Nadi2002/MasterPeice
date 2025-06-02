<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\Station;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenanceRequests = MaintenanceRequest::with(['station'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.maintenance.index', compact('maintenanceRequests'));
    }

    public function show(MaintenanceRequest $maintenance)
    {
        return view('admin.maintenance.show', compact('maintenance'));
    }

    public function edit(MaintenanceRequest $maintenance)
    {
        return view('admin.maintenance.edit', compact('maintenance'));
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
            'completion_date' => 'nullable|date',
        ]);

        $maintenance->update($validated);

        if ($validated['status'] === 'completed') {
            $maintenance->station->update(['status' => 'active']);
        } elseif ($validated['status'] === 'in_progress') {
            $maintenance->station->update(['status' => 'maintenance']);
        }

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'تم تحديث طلب الصيانة بنجاح');
    }

    public function destroy(MaintenanceRequest $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('admin.maintenance.index')
            ->with('success', 'تم حذف طلب الصيانة بنجاح');
    }
}
