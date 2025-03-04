<?php

namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getFields(Request $request)
    {
        $language = $request->input('language');
        $settings = $this->getFieldsByLanguage($language);

        return response()->json([
            'footer_description' => $settings['footer_description'] ?? '',
            'about_us' => $settings['about_us'] ?? '',
            'about_intro' => $settings['about_intro'] ?? '',
            'about_mission' => $settings['about_mission'] ?? '',
            'faq_title' => $settings['faq_title'] ?? '',
            'submit_request' => $settings['submit_request'] ?? '',
            'submit_request_label' => $settings['submit_request_label'] ?? '',
            'banner_title' => $settings['banner_title'] ?? '',
            'banner_description' => $settings['banner_description'] ?? '',
            'banner_button_text' => $settings['banner_button_text'] ?? '',
            'site_name' => $settings['site_name'] ?? '',
            'phone' => $settings['phone'] ?? '',
            'email' => $settings['email'] ?? '',
        ]);
    }

    public function index()
    {
        $settings = Setting::where('type', '!=', 'basic')->pluck('value', 'slug')->toArray();
        $basic = Setting::where('type', 'basic')->pluck('value', 'slug')->toArray();
        return view('dashboard.settings.index', compact('settings', 'basic'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,ar',
            'site_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'footer_description' => 'nullable|string',
            'about_us' => 'nullable|string',
            'about_intro' => 'nullable|string',
            'about_mission' => 'nullable|string',
            'faq_title' => 'nullable|string|max:255',
            'submit_request' => 'nullable|string|max:255',
            'submit_request_label' => 'nullable|string|max:255',
            'banner_title' => 'nullable|string|max:255',
            'banner_description' => 'nullable|string',
            'banner_button_text' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'snapchat' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'google_maps' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:255',

        ]);

        $language = $request->input('language');
        $settingsData = $request->except(['_token', 'logo']);

        // تحديث الحقول النصية
        foreach ($settingsData as $key => $value) {
            $this->updateField($key, in_array($key, $this->basicFields()) ? 'basic' : $language, $value);
        }

        // رفع الملفات
        $this->updateFile($request, 'logo', 'logos');


        return response()->json(['success' => 'Settings updated successfully.']);
    }

    protected function updateField($slug, $type, $value)
    {
        Setting::updateOrCreate(
            ['slug' => $slug, 'type' => $type],
            ['value' => $value]
        );
    }

    protected function updateFile(Request $request, $field, $path)
    {
        if ($request->hasFile($field)) {
            $filePath = $request->file($field)->store($path);
            $this->updateField($field, 'basic', $filePath);
        }
    }

    protected function getFieldsByLanguage($language)
    {
        return Setting::where(['type'=>$language])->pluck('value', 'slug')->toArray();
    }

    protected function basicFields()
    {
        return [
            'phone',
            'email',
            'site_name',
            'facebook',
            'slider' ,
            'twitter',
            'instagram',
            'linkedin',
            'youtube',
            'snapchat',
            'tiktok',
            'google_maps',
            'whatsapp',
            'dark_mode',
        ];
    }
}
