<?php

namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\site\Category;
use App\Models\Translation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ProjectRequest;
class ProjectController extends Controller
{

    public function getProjectRequest()
    {
        $data = ProjectRequest::get();
        return view('dashboard.offers.ProjectRequest' , compact('data'));
    }


    public function getProjectRequestsData() {
    $data = ProjectRequest::query();
    return DataTables::of($data)
        ->addColumn('actions', function ($row) {
            return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item edit-request" href="#" data-id="' . $row->id . '"><i class="fa fa-pencil"></i> Edit</a></li>
                        <li><a class="dropdown-item delete-request" href="#" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</a></li>
                    </ul>
                </div>
            ';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }


    public function index()
    {
        return view('dashboard.project.index');
    }

    public function createPage()
    {
        return view('dashboard.project.add')
            ->with('token', Translation::generateUniqueToken())
            ->with('txt', Project::txt())
            ->with('categories', Category::get());
    }


    public function getTranslations(Request $request)
    {
        $languageId = $request->input('language_id');
        $item_id = $request->input('item_id');

        $translations = Translation::where('language_id', $languageId)
            ->where('translatable_id', $item_id)
            ->where('translatable_type', Project::class)
            ->get();

        return response()->json($translations);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::all();
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
        $description = Translation::select('value')->where('key', 'description')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $category_id = $request->input('category_id', null);

        $translationExists = Translation::where('token', $token)->exists();

        if (!$translationExists) {
            return response()->json(['message' => 'Translation token not found'], 400);
        }

        // تحقق من وجود القيم في جدول translations
        if (empty($name) || empty($title)) {
            return response()->json(['message' => 'Name or Title translation not found'], 400);
        }

        // رفع أول صورة فقط وتخزين مسارها في حقل image
        $imagePath = 'default.png';
        if ($request->hasFile('images')) {
            $firstImage = $request->file('images')[0];
            $imagePath = $firstImage->store('project', 'public');
        }

        $item = Project::create([
            'name' => $name,
            'url' => $request->url ?? '',
            'image' => $imagePath,
            'title' => $title,
            'tr_token' => $token,
            'status' => $request->status,
            'price' => $request->price,
            'description' =>$description,
            'category_id' => is_numeric($category_id) ? $category_id : null,
        ]);

        // رفع باقي الصور وتخزين مساراتها في جدول service_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($index > 0) {

                    $path = $image->store('project', 'public');
                    $item->images()->create(['path' => $path]);
                }
            }
        }

        Translation::where('token', $token)->update([
            'translatable_id' => $item->id,
            'translatable_type' => Project::class,
        ]);

        return response()->json(['message' => 'Service added successfully', 'data' => $item]);
    }

    public function edit($id)
    {
         $project = Project::with(['translations'])->findOrFail($id);
        $txt = Project::txt();
        $categories  = Category::get();
        $languages = Translation::all();
        return view('dashboard.project.edit', compact('project', 'categories','txt', 'languages'));
    }

    public function update(Request $request, $id)
    {
       $project = Project::findOrFail($id);
       $project->update($request->only(['status', 'price', 'description', 'category_id' ,'url']));

        if ($request->hasFile('images')) {
            $firstImage = $request->file('images')[0];
            $imagePath = $firstImage->store('project', 'public');
           $project->update('image' , $imagePath);
        }


        foreach ($request->except(['_token', '_method']) as $key => $translations) {
            if (is_array($translations)) {
                foreach ($translations as $languageId => $value) {
                    Translation::updateOrCreate(
                        [
                            'translatable_id' =>$project->id,
                            'translatable_type' => Project::class,
                            'language_id' => $languageId,
                            'key' => $key,
                        ],
                        ['value' => $value, 'status' => 1]
                    );
                }
            }
        }

        return redirect()->route('project.index')->with('success', 'Service updated successfully');
    }

    public function destroy(Request $request)
    {
       $project = Project::findOrFail($request->id);
       $project->delete();

        return response()->json(['success' => 'Service deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
       $project = Project::findOrFail($request->id);
       $project->status =$project->status == '1' ? '0' : '1';
       $project->save();

        return response()->json(['success' => 'Service status updated successfully.']);
    }


}
