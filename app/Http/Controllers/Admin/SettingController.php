<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'currency' => 'required|string|max:10',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'maintenance_fee' => 'required|numeric|min:0',
            'min_booking_duration' => 'required|integer|min:1',
            'max_booking_duration' => 'required|integer|min:1',
            'booking_notification_email' => 'required|boolean',
            'maintenance_notification_email' => 'required|boolean',
            'google_maps_api_key' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear settings cache
        Cache::forget('settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }

    public function clearCache()
    {
        Cache::forget('settings');
        return redirect()->route('admin.settings.index')
            ->with('success', 'تم مسح ذاكرة التخزين المؤقت بنجاح');
    }
}
