<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Station;
use App\Models\MaintenanceRequest;
use Carbon\Carbon;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch reports with pagination
        $reports = Report::orderBy('created_at', 'desc')->paginate(10); // Adjust pagination number as needed

        // The view resources/views/admin/reports/index.blade.php expects a variable named $reports
        // The previous code calculated stats and bookings, which are not used in the current view.
        // If those stats are needed elsewhere or in a different part of the view, they should be handled separately.
        
        // Pass the reports to the view
        return view('admin.reports.index', compact('reports'));
    }

    public function create()
    {
        // This method is responsible for showing the form to create a new report.
        return view('admin.reports.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:financial,operational,maintenance,performance',
            'content' => 'required|string',
            'status' => 'required|string|in:active,draft,archived',
        ]);

        // Create a new Report instance with the validated data
        Report::create($validatedData);

        // Redirect back to the reports index page with a success message
        return redirect()->route('admin.reports.index')->with('success', 'تم إضافة التقرير بنجاح!');
    }

    public function edit(Report $report)
    {
        // This method is responsible for showing the form to edit an existing report.
        // The Report model instance is automatically injected via route model binding.
        return view('admin.reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:financial,operational,maintenance,performance',
            'content' => 'required|string',
            'status' => 'required|string|in:active,draft,archived',
        ]);

        // Update the report instance with the validated data
        $report->update($validatedData);

        // Redirect back to the reports index page with a success message
        return redirect()->route('admin.reports.index')->with('success', 'تم تحديث التقرير بنجاح!');
    }

    public function export()
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth());
        $endDate = request('end_date', Carbon::now()->endOfMonth());

        $bookings = Booking::with(['user', 'station'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // هنا يمكنك إضافة كود لتصدير البيانات إلى ملف Excel أو PDF
        return response()->json($bookings);
    }
}
