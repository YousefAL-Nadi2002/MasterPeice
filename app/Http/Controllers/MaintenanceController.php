<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service; // استيراد نموذج Service
use App\Models\ServiceProvider; // استيراد نموذج ServiceProvider

class MaintenanceController extends Controller
{
    /**
     * Display the maintenance services page and fetch data.
     */
    public function index()
    {
        // جلب جميع الخدمات (وربما تصنيفها حسب النوع: كهربائية/ميكانيكية)
        // يمكنك جلبها كلها هنا وتصنيفها في الـ view أو JavaScript
        $services = Service::all();

        // يمكنك أيضاً جلب مقدمي الخدمة هنا إذا كنت ستمررهم كلهم للـ view
        // $serviceProviders = ServiceProvider::all();

        // تمرير البيانات إلى الـ view 'maintenance.blade.php'
        return view('maintenance', [
            'services' => $services,
            // 'serviceProviders' => $serviceProviders, // إذا مررتهم كلهم
        ]);
    }

    // إذا كنت ستستخدم AJAX لعرض مقدمي خدمة لخدمة معينة، ستحتاج لدالة هنا
    // public function getProvidersByService($serviceId)
    // {
    //     // جلب الخدمة
    //     $service = Service::find($serviceId);

    //     if (!$service) {
    //         return response()->json(['message' => 'Service not found.'], 404);
    //     }

    //     // جلب مقدمي الخدمة المرتبطين بهذه الخدمة (يتطلب علاقة في النماذج)
    //     // افترض أن لديك علاقة many-to-many اسمها 'providers' في نموذج Service
    //     $providers = $service->providers;

    //     return response()->json($providers);
    // }
}
