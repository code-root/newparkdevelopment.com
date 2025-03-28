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


    public function getCategory() {
        $data =  Category::select(['id','name','title'])->get();
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }


        public function apiAllProject() {
        $project = Project::with(['category' ,'images' ])->get();
        return response()->json([
            'status' => true,
            'data' => $project,
        ]);
    }

    public function getIdProject($id) {
        $project = Project::where('id' ,$id)->with(['category' ,'images' ])->get();
        return response()->json([
            'status' => true,
            'data' => $project,
        ]);
    }


        // Fetch a specific blog by ID with translations
        public function getBlogId(Request $request)
        {
            $blog = Blog::where('id', $request->blog_id)->first();
            return ['blog' => $blog ?? 'Blog not found'];
        }


    // Fetch all blogs with translations
    public function getBlogs(Request $request)
    {
        $blogs = Blog::all();
        return ['blogs' => $blogs ?? []];
    }



    public function showPage($id, Request $request)
    {
        $page = Page::findOrFail($id);


        return response()->json([
            'name' => $page->name,
            'description' => $page->description,
            'meta' => $page->meta,
        ]);
    }





    public function getPage(Request $request) {
        $pages = Page::all();
        $data = [];

        foreach ($pages as $page) {

            $data[] = [
                'id' => $page->id,
                'name' => $page->name,
                'meta' => $page->meta ?? '',
            ];
        }

        if (empty($data)) {
            return response()->json(['error' => 'Pages not found'], 404);
        }

        return response()->json($data);
    }

    public function successPartners()
    {
        $partners = SuccessPartner::all();
        return response()->json([
            'status' => true,
            'data' => $partners,
        ]);
    }

    public function viewImage(Request $request, $modelName)
    {
        try {
            if (empty($request->nameVar)) {
                throw new \Exception('Image variable not specified');
            } else {
                $nameVar = $request->nameVar;
            }


            if ($modelName == 'Setting') {
                $model = Setting::where('slug', $nameVar)->first();

                $imagePath = $model->value;
            } else {
                if (!class_exists($modelName)) {
                    throw new \Exception('Model not found');
                }
                $model = resolve($modelName);

                // تحميل النموذج ديناميكيًا

                // البحث عن السجل باستخدام المعرف
                $record = $model::find($request->id);
                if (!$record) {
                    throw new \Exception('Record not found');
                }

                $imagePath = $record->$nameVar;
                if (!Storage::exists($imagePath)) {
                    throw new \Exception('Image not found');
                }
            }



            // عرض الصورة
            return response()->file(storage_path('app/' . $imagePath), [
                'Content-Type' => Storage::mimeType($imagePath),
                'Content-Disposition' => 'inline',
            ]);
        } catch (\Exception $e) {
            // عرض الصورة الافتراضية في حالة حدوث خطأ
            return response()->file(storage_path('app/default_large.png'), [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline',
            ]);
        }
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
