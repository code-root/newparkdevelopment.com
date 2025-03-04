<?php

namespace App\Http\Controllers\dashboard\site;
use App\Http\Controllers\Controller;

use App\Models\App\Page;

use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller
{
    public function index()
    {
        return view('dashboard.section.index');
    }

    public function savePage(Request $request, $section_id)
    {
        $section = Section::findOrFail($section_id);

        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $pageData = $request->only(['name_ar', 'name_en', 'description_ar', 'description_en']);
        $pageData['section_id'] = $section->id;
        $pageData['status'] = 'section';
        Page::create($pageData);
        return response()->json(['success' => 'تم الإنشاء بنجاح.']);
    }



    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Section::with(['pages' => function($query) {
                $query->select('id', 'name_ar', 'name_en', 'section_id'); // حدد الأعمدة التي تريدها
            }])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sections,slug',
            'status' => 'required',
        ]);

        Section::create($request->all());

        return response()->json(['success' => 'تمت الإضافة بنجاح.']);
    }

    public function edit($id)
    {
        $section = Section::findOrFail($id);
        return [
            'data' => $section,
        ];
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            // 'slug' => 'required|string|max:255|unique:sections,slug,' . $section->id,
            // 'status' => 'required',
        ]);

        $section->update($request->all());

        return response()->json(['success' => 'تم التحديث بنجاح.']);
    }

    public function destroy(Request $request)
    {
        $section = Section::findOrFail($request->id);
        $section->delete();

        return response()->json(['success' => 'تم الحذف بنجاح.']);
    }

    public function toggleStatus(Request $request)
    {
        $section = Section::findOrFail($request->id);
        $section->status = $section->status == '1' ? '0' : '1';
        $section->save();

        return response()->json(['success' => 'تم تغيير الحالة بنجاح.']);
    }
}
