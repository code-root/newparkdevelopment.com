<?php

namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\site\Category;
use App\Models\Translation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ProjectRequest;

class ProjectController extends Controller
{
    public function getProjectRequest() {
        $data = ProjectRequest::get();
        return view('dashboard.offers.ProjectRequest', compact('data'));
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
            ->with('categories', Category::get());
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
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'count' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
            'status' => 'required|string|in:active,inactive',
            'price' => 'required|numeric',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = 'default.png';
        if ($request->hasFile('images')) {
            $firstImage = $request->file('images')[0];
            $imagePath = $firstImage->store('project', 'public');
        }

        $project = Project::create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'count' => $request->count,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($index > 0) {
                    $path = $image->store('project', 'public');
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'path' => $path,
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Project added successfully', 'data' => $project]);
    }

    public function edit($id)
    {
        $project = Project::with(['images'])->findOrFail($id);
        $categories = Category::get();
        return view('dashboard.project.edit', compact('project', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'count' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
            'status' => 'required|string|in:active,inactive',
            'price' => 'required|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $project = Project::findOrFail($id);
        $project->update($request->only(['name', 'title', 'description', 'count', 'category_id', 'status', 'price']));

        if ($request->hasFile('images')) {
            $firstImage = $request->file('images')[0];
            $imagePath = $firstImage->store('project', 'public');
            $project->update(['image' => $imagePath]);

            foreach ($request->file('images') as $index => $image) {
                if ($index > 0) {
                    $path = $image->store('project', 'public');
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'path' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('project.index')->with('success', 'Project updated successfully');
    }

    public function destroy(Request $request)
    {
        $project = Project::findOrFail($request->id);
        $project->delete();

        return response()->json(['success' => 'Project deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $project = Project::findOrFail($request->id);
        $project->status = $project->status == 'active' ? 'inactive' : 'active';
        $project->save();

        return response()->json(['success' => 'Project status updated successfully.']);
    }

    public function projectImageDelete () 
    {
        $image = ProjectImage::find($request->id);
        if ($image) {
            Storage::delete($image->path);
            $image->delete();
            return response()->json(['success' => 'تم حذف الصورة بنجاح.']);
        }
        return response()->json(['error' => 'حدث خطأ أثناء الحذف.'], 500);
    }
}