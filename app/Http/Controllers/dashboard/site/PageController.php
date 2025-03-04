<?php

namespace App\Http\Controllers\dashboard\site;
use App\Http\Controllers\Controller;
use App\Models\App\Page;
use App\Models\Section;
use App\Models\Translation;
use Illuminate\Http\Request;

class PageController extends Controller
{



    public function index()
    {
        $pages = Page::where('type' , 'site')->get();
        return view('dashboard.pages.index', compact('pages'));
    }

    public function showPage($name)
    {
        // Replace dashes with spaces
        $name = str_replace('-', ' ', $name);
        // Search for the page by name
        $page = Page::where('name', 'LIKE', "%$name%")->first();

        if (!$page) {
            return abort(404, 'Page not found');
        }

        return view('site.pages.index', compact('page'));
    }



    public function create()
    {
        $pages = Page::where('type' , 'site')->get();
        return view('dashboard.pages.section-create')
        ->with('token', Translation::generateUniqueToken())
        ->with('txt', Page::txt());
    }


    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $section =  Section::where('id',$page->section_id)->first();
        return view('dashboard.pages.edit', compact('page' , 'section'));
    }

    public function createPage(Request $request)
    {
        $token =  $request->token ;
        $name = Translation::select('value')->where('key', 'name')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $description = Translation::select('value')->where('key', 'description')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $meta = Translation::select('value')->where('key', 'meta')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $pageData['type'] = 'site';
        $pageData['tr_token'] =$token ;
        $pageData['status'] = $request->status ;
        $pageData['name'] = $name;
        $pageData['description'] = $description;
        $pageData['meta'] = $meta;
        $item  = Page::create($pageData);

        $item_id = Translation::where('token' , $token)->update([
            'translatable_id' => $item->id,
            'translatable_type' => Page::class,
        ]);
        return response()->json(['success' => 'تم الإنشاء بنجاح.']);
    }



    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return response()->json(['message' => 'Page deleted successfully']);
    }

    public function update(Request $request)
    {
        $page = Page::findOrFail($request->page_id);
         $token =  Translation::select(['token'])->where(['translatable_id' => $request->page_id,'translatable_type' => Page::class])->first()['token'] ?? '';

        $name = Translation::select('value')->where('key', 'name')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $description = Translation::select('value')->where('key', 'description')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $meta = Translation::select('value')->where('key', 'meta')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';

        $data['status'] = $request->status ;
        $data['name'] = $name;
        $data['description'] = $description;
        $data['meta'] = $meta;
        $data['tr_token'] = $token;
        $page->update($data);



        return response()->json(['message' => 'Page updated successfully']);
    }
    public function getTranslations(Request $request)
    {
        $languageId = $request->input('language_id');
        $item_id = $request->input('item_id');

        $translations = Translation::where('language_id', $languageId)
            ->where('translatable_id', $item_id)
            ->where('translatable_type', Page::class)
            ->get();

        return response()->json($translations);
    }
}

