<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Project;
use App\Models\Setting;
use App\Models\site\Faq;
use App\Models\site\Page;
use Illuminate\Http\Request;
use App\Models\site\SuccessPartner;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog\Blog;use App\Models\site\Category;

class ApiController extends Controller
{


    public function home( $locale = 'ar')
    {
        $settings = Setting::pluck('value', 'slug')->toArray();
        $socials = Setting::whereIn('slug', ['facebook', 'instagram', 'linkedin', 'twitter' , 'google_maps' , 'email' , 'site_name' , 'whatsapp' , 'phone'])->pluck('value', 'slug')->toArray();
        $faqs = Faq::all();
        return response()->json([
            'settings' => $settings,
            'socials' => $socials,
            'faqs' => $faqs,
        ]);
    }

    public function indexPage()
    {
        $pages = Page::all(['id', 'name', 'type']);
        return response()->json([
            'status' => 'success',
            'data' => $pages
        ], 200);
    }

    public function showPage($id) {
        $page = Page::find($id);

        if (!$page) {
            return response()->json([
                'status' => 'error',
                'message' => 'Page not found'
            ], 404);
        }

        // إرجاع تفاصيل الصفحة
        return response()->json([
            'status' => 'success',
            'data' => $page
        ], 200);
    }



    public function ContactStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'contact-name' => 'required|string|max:255',
                'contact-email' => 'required|email|max:255',
                'contact-phone' => 'nullable|string|max:20',
                'contact-message' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        Contact::create([
            'name' => $validatedData['contact-name'],
            'email' => $validatedData['contact-email'],
            'phone' => $validatedData['contact-phone'],
            'message' => $validatedData['contact-message'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Your message has been sent successfully.'
        ]);
    }
}
