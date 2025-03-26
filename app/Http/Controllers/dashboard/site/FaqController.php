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
        return view('dashboard.faq.add');
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



    public function edit($id)
    {
        $data = Faq::findOrFail($id);
        return view('dashboard.faq.edit', compact('data'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:5000',
            'status' => 'required|boolean',
        ]);

        $item = Faq::create([
            'question' => $validatedData['question'],
            'answer' => $validatedData['answer'],
            'status' => $validatedData['status'],
        ]);

        return response()->json(['message' => 'Added Faq successfully', 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'question' => 'sometimes|required|string|max:255',
            'answer' => 'sometimes|required|string|max:5000',
            'status' => 'required|boolean',
        ]);

        $data = Faq::findOrFail($id);
        $data->update($validatedData);
        return back()->with('success', 'Faq updated successfully');
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
