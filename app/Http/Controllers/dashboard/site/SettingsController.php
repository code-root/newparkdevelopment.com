<?php

namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
        $settings = Setting::where('type', '!=', 'basic')->pluck('value', 'slug')->toArray();
        $basic = Setting::where('type', 'basic')->pluck('value', 'slug')->toArray();
        return view('dashboard.settings.index', compact('settings', 'basic'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'footer_description' => 'nullable|string',
            'about_us' => 'nullable|string',
            'about_intro' => 'nullable|string',
            'about_mission' => 'nullable|string',
            'faq_title' => 'nullable|string|max:255',
            'hero_cta' => 'nullable|string|max:255',
            'rental_stats_count' => 'nullable|string|max:255',
            'rental_stats_text' => 'nullable|string|max:255',
            'google_maps' => 'nullable',
            'buy_stats_count' => 'nullable|string|max:255',
            'buy_stats_text' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_title_1' => 'nullable|string|max:255',
            'hero_title_2' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string|max:255',
            'slider_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // صورة السلايدر
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // الشعار
        ]);

        $settingsData = $request->except(['_token', 'slider_image', 'logo']);

        // تحديث الحقول النصية
        foreach ($settingsData as $key => $value) {
            $this->updateField($key, in_array($key, $this->basicFields()) ? 'basic' : '', $value);
        }

        // رفع صورة السلايدر
        if ($request->hasFile('slider_image')) {
            $sliderImagePath = $request->file('slider_image')->store('sliders');
            $this->updateField('slider_image', 'basic', $sliderImagePath);
        }

        // رفع الشعار
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos');
            $this->updateField('logo', 'basic', $logoPath);
        }

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
        return Setting::where(['type' => $language])->pluck('value', 'slug')->toArray();
    }

    protected function basicFields()
    {
        return [
            'phone',
            'email',
            'site_name',
            'facebook',
            'twitter',
            'instagram',
            'linkedin',
            'youtube',
            'snapchat',
            'tiktok',
            'google_maps',
            'whatsapp',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ];
    }
}
