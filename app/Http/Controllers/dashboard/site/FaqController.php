<?php

namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;

use App\Models\site\Faq;
use App\Models\Translation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FaqController extends Controller
{
    public function index()
    {
        return view('dashboard.faq.index');
    }

    public function createPage()
    {
        return view('dashboard.faq.add')
        ->with('token', Translation::generateUniqueToken())
        ->with('txt', Faq::txt());
    }

    public function getTranslations(Request $request)
    {
        $languageId = $request->input('language_id');
        $item_id = $request->input('item_id');

        $translations = Translation::where('language_id', $languageId)
            ->where('translatable_id', $item_id)
            ->where('translatable_type', Faq::class)
            ->get();

        return response()->json($translations);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }


    public function create(Request $request)
    {
        $token = $request->token ;
        $question = Translation::select('value')->where('key', 'question')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $answer = Translation::select('value')->where('key', 'answer')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';

        $item = Faq::create([
            'answer' =>$answer,
            'question' =>$question,
            'tr_token'=>$token,
            'status'=>$request->status,
        ]);

        $button_text = Translation::where('token' , $token)->update([
            'translatable_id' => $item->id,
            'translatable_type' => Faq::class,
        ]);

        return response()->json(['message' => 'Added Faq successfully', 'data' => $item]);
    }

    public function edit($id)
    {
        $data = Faq::with(['translations'])->findOrFail($id);
        $txt = Faq::txt();
        $languages = Translation::all();
        return view('dashboard.faq.edit', compact('data', 'txt', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $data = Faq::findOrFail($id);
        $data->update($request->only(['status']));
      foreach ($request->except(['_token', '_method']) as $key => $translations) {
        if (is_array($translations)) {
            foreach ($translations as $languageId => $value) {
                Translation::updateOrCreate(
                    [
                        'translatable_id' => $data->id,
                        'translatable_type' => Faq::class,
                        'language_id' => $languageId,
                        'key' => $key,
                    ],
                    ['value' => $value, 'status' => 1]
                );
            }
        }
        }

        return view('dashboard.faq.index')->with('success', 'Faq updated successfully');
    }


    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();
            return response()->json(['success' => 'Faq deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Faq not found'], 404);
        }
    }

    public function toggleStatus(Request $request)
    {
        $Faq = Faq::findOrFail($request->id);
        $Faq->status = $Faq->status == '1' ? '0' : '1';
        $Faq->save();

        return response()->json(['success' => 'updated']);
    }
}
