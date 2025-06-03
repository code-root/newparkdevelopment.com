<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use App\Models\site\Page;
use Illuminate\Http\Request;

class ApiController extends Controller
{


    public function home( $locale = 'ar')
    {
        $settings = Setting::pluck('value', 'slug')->toArray();
        $socials = Setting::whereIn('slug', ['facebook', 'instagram', 'linkedin', 'twitter' , 'google_maps' , 'email' , 'site_name' , 'whatsapp' , 'phone'])->pluck('value', 'slug')->toArray();
        return response()->json([
            'settings' => $settings,
            'socials' => $socials,
        ]);
    }

    public function getPageType($type)
    {
        $pages = Page::select(['id', 'name', 'type'])->with(['images'])->where('type', $type)->get();
        return response()->json([
            'status' => 'success',
            'data' => $pages
        ], 200);
    }

    public function indexPage()
    {
        $pages = Page::select(['id', 'name', 'type'])->with(['images'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $pages
        ], 200);
    }

    public function showPage($id) {
        $page = Page::where('id',$id)->with(['images'])->first();

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
