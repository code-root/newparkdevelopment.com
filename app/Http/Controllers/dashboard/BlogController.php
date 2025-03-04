<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\site\Category;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{

    public function index()
    {
        return view('dashboard.blog.index');
    }

    public function createPage()
    {
        return view('dashboard.blog.add')
            ->with('token', Translation::generateUniqueToken())
            ->with('txt', Blog::txt())
            ->with('categories', Category::get());
    }


    public function getTranslations(Request $request)
    {
        $languageId = $request->input('language_id');
        $item_id = $request->input('item_id');

        $translations = Translation::where('language_id', $languageId)
            ->where('translatable_id', $item_id)
            ->where('translatable_type', Blog::class)
            ->get();

        return response()->json($translations);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function create(Request $request)
    {
        $token = $request->token;
        $name = Translation::select('value')->where('key', 'name')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $title = Translation::select('value')->where('key', 'title')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $description = $request->input('description', '');
        $category_id = $request->input('category_id', null);

        $translationExists = Translation::where('token', $token)->exists();

        if (!$translationExists) {
            return response()->json(['message' => 'Translation token not found'], 400);
        }

        // تحقق من وجود القيم في جدول translations
        if (empty($name) || empty($title)) {
            return response()->json(['message' => 'Name or Title translation not found'], 400);
        }


        $imagePath = 'default.png';
        if ($request->hasFile('image')) {
            $firstImage = $request->file('image');
            $imagePath = $firstImage->store('blogs', 'public');
        }

        $item = Blog::create([
            'name' => $name,
            'author' => $request->author ?? '',
            'image' => $imagePath,
            'title' => $title,
            'tr_token' => $token,
            'status' => $request->status,
            'description' => is_string($description) ? $description : '',
            'category_id' => is_numeric($category_id) ? $category_id : null,
        ]);

        // رفع باقي الصور وتخزين مساراتها في جدول Blog_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($index > 0) { // تخطي أول صورة لأنها تم تخزينها بالفعل في حقل image
                    $path = $image->store('blogs', 'public');
                    $item->images()->create(['path' => $path]);
                }
            }
        }

        Translation::where('token', $token)->update([
            'translatable_id' => $item->id,
            'translatable_type' => Blog::class,
        ]);

        return response()->json(['message' => 'Blog added successfully', 'data' => $item]);
    }

    public function edit($id)
    {
        $blog = Blog::with(['translations'])->findOrFail($id);
        $txt = Blog::txt();
        $languages = Translation::all();
        return view('dashboard.blog.edit', compact('blog', 'txt', 'languages'));
    }

    public function update(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            // تحديث البيانات الأساسية
            $blog->update($request->only(['status', 'price', 'description', 'category_id']));

            // تحديث الترجمات
            foreach ($request->except(['_token', '_method', 'images']) as $key => $translations) {
                if (is_array($translations)) {
                    foreach ($translations as $languageId => $value) {
                        Translation::updateOrCreate(
                            [
                                'translatable_id' => $blog->id,
                                'translatable_type' => Blog::class,
                                'language_id' => $languageId,
                                'key' => $key,
                            ],
                            ['value' => $value, 'status' => 1]
                        );
                    }
                }
            }

            if ($request->hasFile('images')) {
                if ($blog->images) {
                    foreach ($blog->images as $image) {
                        Storage::disk('public')->delete($image->path);
                        $image->delete();
                    }
                }

                // رفع الصور الجديدة
                foreach ($request->file('images') as $image) {
                    $path = $image->store('blogs', 'public');
                    $blog->images()->create(['path' => $path]);
                }
            }

            return redirect()->route('blog.index')->with('success', 'Blog updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update blog.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $blog = Blog::findOrFail($request->id);
            // حذف الصور المرتبطة بالمقالة (إذا كانت موجودة)
            if ($blog->images) {
                foreach ($blog->images as $image) {
                    // حذف الصورة من التخزين
                    Storage::disk('public')->delete($image->path);
                    // حذف الصورة من قاعدة البيانات
                    $image->delete();
                }
            }

            // حذف المقالة
            $blog->delete();
            return response()->json(['success' => 'Blog deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete blog.'], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        $Blog = Blog::findOrFail($request->id);
        $Blog->status = $Blog->status == '1' ? '0' : '1';
        $Blog->save();

        return response()->json(['success' => 'Blog status updated successfully.']);
    }



}
