<?php

namespace App\Http\Controllers;

use App\Models\App\DeviceUser;
use App\Models\ProjectRequest;
use Illuminate\Http\Request;
use Browser;

class SubscriberController extends Controller
{

    /**
     * Handle user subscription request
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'project_types_ids' => 'required|array|distinct',
            'project_types_ids.*' => 'exists:categories,id',
            'budget' => 'required|integer|min:1000|max:5000',
            'details' => 'nullable|string|max:5000',
        ]);

        // Get device information
        $deviceData = $this->getDeviceData($request);
        $deviceId = $this->getDeviceToken($deviceData);

        if (!$deviceId) {
            $device = DeviceUser::create($deviceData);
            $deviceId = $device->id;
        }

        // التحقق من وجود طلب سابق بنفس البريد الإلكتروني أو الجهاز
        $existingRequest = ProjectRequest::where('email', $request->email)
            ->orWhere('device_id', $deviceId)
            ->first();

        if ($existingRequest) {
            return response()->json(['error' => 'You have already submitted a request.'], 400);
        }

        try {
            // Create project request
            $projectRequest = ProjectRequest::create([
                'email' => $request->email,
                'name' => $request->name,
                'budget' => $request->budget,
                'details' => $request->details ?? null,
                'device_id' => $deviceId,
                'ip' => $request->ip(),
            ]);

            // Attach categories to the project request
            $projectRequest->categories()->attach($request->project_types_ids);

            // Update the device with the request ID
            DeviceUser::where('id', $deviceId)->update(['request_id' => $projectRequest->id]);

            return response()->json(['message' => 'Subscription successful.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to process subscription.'], 500);
        }
    }


    /**
     * Retrieve device details
     */
    public static function getDeviceData($request)
    {
        return [
            'device_type' => Browser::deviceType(),
            'device_name' => Browser::deviceModel(),
            'device_os' => Browser::platformName(),
            'device_version' => Browser::platformVersion(),
            'device_browser' => Browser::browserName(),
            'device_browser_version' => Browser::browserVersion(),
            'device_ip' => $request->ip(),
            'is_mobile' => Browser::isMobile(),
            'is_tablet' => Browser::isTablet(),
            'is_desktop' => Browser::isDesktop(),
            'is_bot' => Browser::isBot(),
        ];
    }

    /**
     * Store device token if not exists
     */
    public function storeToken(Request $request)
    {
        $deviceData = $this->getDeviceData($request);
        $deviceId = $this->getDeviceToken($deviceData);

        if (!$deviceId) {
            $device = DeviceUser::create($deviceData);
            $deviceId = $device->id;
        }
    }

    /**
     * Generate and retrieve the device token
     */
    public function getDeviceToken(array $deviceData)
    {
        $deviceToken = sha1(json_encode($deviceData));
        $device = DeviceUser::where('device_token', $deviceToken)->first();
        return $device ? $device->id : null;
    }
}
