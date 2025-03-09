<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;

use App\Models\site\Gallery;
use App\Models\site\Category;
use App\Models\App\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::with('category')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        $categories = Category::pluck('name', 'id');
        return view('dashboard.gallery.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'status' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = $request->file('image')->store('galleries');
        Gallery::create([
            'image' => $imagePath,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'page_id' =>0,
        ]);

        return response()->json(['success' => 'تمت الإضافة بنجاح.']);
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $categories = Category::pluck('name_en', 'id');
        return [
            'categories' => $categories,
            'gallery' => $gallery
        ];
    }




    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            // galleries
            Storage::delete('public/galleries/' . $gallery->image);
            $gallery->image =  $request->file('image')->store('galleries');
        }

        $gallery->status = $request->status;
        $gallery->category_id = $request->category_id;
        $gallery->save();

        return response()->json(['success' => 'تم التحديث بنجاح.']);
    }

    public function destroy(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);
        $gallery->delete();

        return response()->json(['success' => 'تم الحذف بنجاح.']);
    }

    public function toggleStatus(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);
        $gallery->status = $gallery->status == '1' ? '0' : '1';
        $gallery->save();

        return response()->json(['success' => 'تم تغيير الحالة بنجاح.']);
    }
}
