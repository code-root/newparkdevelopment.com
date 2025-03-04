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
        return view('dashboard.category.add')
        ->with('token', Translation::generateUniqueToken())
        ->with('txt', Category::txt());
    }

    public function getTranslations(Request $request)
    {
        $languageId = $request->input('language_id');
        $item_id = $request->input('item_id');

        $translations = Translation::where('language_id', $languageId)
            ->where('translatable_id', $item_id)
            ->where('translatable_type', Category::class)
            ->get();

        return response()->json($translations);
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
        $token = $request->token;
        $name = Translation::select('value')->where('key', 'name')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $title = Translation::select('value')->where('key', 'title')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';


        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('icons', 'public');
        }

        $item = Category::create([
            'name' => $name,
            'title' => $title,
            'tr_token' => $token,
            'status' => $request->status,
            'icon' => $iconPath,
            'color_class' => $request->color_class,
        ]);

        Translation::where('token', $token)->update([
            'translatable_id' => $item->id,
            'translatable_type' => Category::class,
        ]);

        return response()->json(['message' => 'Added Category successfully', 'data' => $item]);
    }

    public function edit($id)
    {
        $data = Category::with(['translations'])->findOrFail($id);
        $txt = Category::txt();
        $languages = Translation::all();
        return view('dashboard.category.edit', compact('data', 'txt', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $data = Category::findOrFail($id);
        $data->update($request->only(['status']));
    foreach ($request->except(['_token', '_method']) as $key => $translations) {
        if (is_array($translations)) {
            foreach ($translations as $languageId => $value) {
                Translation::updateOrCreate(
                    [
                        'translatable_id' => $data->id,
                        'translatable_type' => Category::class,
                        'language_id' => $languageId,
                        'key' => $key,
                    ],
                    ['value' => $value, 'status' => 1]
                );
            }
        }
        }

        // return $data->tr_token;
        $name = Translation::select('value')->where('key', 'name')->where('token', $data->tr_token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $title = Translation::select('value')->where('key', 'title')->where('token', $data->tr_token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $item = $data->update([
            'name' => $name,
            'title' => $title,
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
