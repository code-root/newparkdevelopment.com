<?php

namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;
use App\Models\site\Category;
use App\Models\Translation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('dashboard.category.index');
    }

    public function createPage()
    {
        return view('dashboard.category.add');
    }


    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::all();
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
            'status' => 'required|boolean',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('icons', 'public');
        }

        $item = Category::create([
            'name' => $request->name,
            'title' => $request->title,
            'tr_token' => $request->token,
            'status' => $request->status,
            'icon' => $iconPath,
            'color_class' => $request->color_class,
        ]);

        return response()->json(['message' => 'Added Category successfully', 'data' => $item]);
    }
    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view('dashboard.category.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'status' => 'required|boolean',
            'color_class' => 'nullable|string|max:255',
        ]);

        $data->update([
            'name' => $request->name,
            'title' => $request->title,
            'status' => $request->status,
            'color_class' => $request->color_class,
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }


    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->delete();

        return response()->json(['success' => 'تم الحذف بنجاح.']);
    }

    public function toggleStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $category->status == '1' ? '0' : '1';
        $category->save();

        return response()->json(['success' => 'تم تغيير الحالة بنجاح.']);
    }
}
