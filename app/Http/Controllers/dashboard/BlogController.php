<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog\Blog;
use App\Models\site\Category;
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
            ->with('categories', Category::get());
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
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // رفع الصورة الرئيسية
            $imagePath = 'default.png';
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('blogs', 'public');
            }

            // إنشاء المقالة
            $item = Blog::create([
                'name' => $request->name,
                'author' => $request->author ?? '',
                'image' => $imagePath,
                'title' => $request->title,
                'status' => $request->status,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('blogs', 'public');
                    $item->images()->create(['path' => $path]);
                }
            }

            return response()->json(['message' => 'Blog added successfully', 'data' => $item]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add blog.', 'error' => $e->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories=  category::get();
        return view('dashboard.blog.edit', compact('blog','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $blog = Blog::findOrFail($id);

            $blog->update([
                'name' => $request->name,
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);

            // تحديث الصورة الرئيسية
            if ($request->hasFile('image')) {
                if ($blog->image && $blog->image !== 'default.png') {
                    Storage::disk('public')->delete($blog->image);
                }

                $imagePath = $request->file('image')->store('blogs', 'public');
                $blog->update(['image' => $imagePath]);
            }

            if ($request->hasFile('images')) {
                foreach ($blog->images as $image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }

                foreach ($request->file('images') as $image) {
                    $path = $image->store('blogs', 'public');
                    $blog->images()->create(['path' => $path]);
                }
            }

            return response()->json(['message' => 'Blog updated successfully', 'data' => $blog]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update blog.', 'error' => $e->getMessage()], 500);
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
