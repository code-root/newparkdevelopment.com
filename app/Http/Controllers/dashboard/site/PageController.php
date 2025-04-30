<?php

namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;
use App\Models\site\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{

    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->has('type') && in_array($request->type, ['regular', 'section', 'article'])) {
            $query->where('type', $request->type);
        }

        $pages = $query->latest()->paginate(10);

        return view('dashboard.pages.index', compact('pages'));
    }

        public function create()
    {
        return view('dashboard.pages.create');
    }


    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('dashboard.pages.edit', compact('page'));
    }

    public function show(Request $request)
    {
        $page = Page::findOrFail($request->id);
        return response()->json($page);
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return response()->json(['message' => 'Page deleted successfully']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,'.$id,
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'type' => 'required|in:regular,section,article',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $page = Page::findOrFail($id);
        $page->update($data);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('pages', 'public');
                $page->images()->create(['image' => $path]);
            }
        }
        return response()->json([
            'message' => 'Page updated successfully',
            'page' => $page
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'type' => 'required|in:regular,section,article',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data['slug'] = Str::slug($request->slug ?? $request->name);

        $page = Page::create($data);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('pages', 'public');
                $page->images()->create(['image' => $path]);
            }
        }

        return redirect()->route('pages.index')->with('success', 'pages updated successfully');
    }

    public function destroyImage($id)
{
    $image = PageImage::findOrFail($id);
    Storage::disk('public')->delete($image->image);
    $image->delete();

    return response()->json(['message' => 'Image deleted']);
}


    public function checkSlug(Request $request)
    {
        $slug = Str::slug($request->slug ?? $request->name);
        $exists = Page::where('slug', $slug)
                    ->when($request->id, function($query) use ($request) {
                        $query->where('id', '!=', $request->id);
                    })
                    ->exists();

        return response()->json([
            'slug' => $slug,
            'exists' => $exists,
            'valid' => !$exists
        ]);
    }
}
