<?php

namespace App\Http\Controllers\dashboard\site;
use App\Http\Controllers\Controller;

use App\Models\site\SuccessPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SuccessPartnerController extends Controller
{
    public function index() {

        $successPartners = SuccessPartner::all();

        return view('dashboard.success-partners.index', compact('successPartners'));
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255', // Allow empty name
            'logos.*' => 'required|image|mimes:svg,jpeg,png,jpg,gif|max:2048', // Validate each image in the array
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Handle multiple files
        $logos = [];
        foreach ($request->file('logos') as $file) {
            $logoPath = $file->store('public/logos');
            $logos[] = ($logoPath);
        }

        // Handle empty name
        $name = $request->filled('name') ? $request->name : 'Default Name';

        // Create SuccessPartner records
        foreach ($logos as $logo) {
            $successPartner = new SuccessPartner();
            $successPartner->name = $name;
            $successPartner->logo = $logo;
            $successPartner->save();
        }

        return response()->json(['success' => true]);
    }


    public function edit($id)
    {
        $successPartner = SuccessPartner::find($id);
        if (!$successPartner) {
            return response()->json(['success' => false, 'message' => 'Record not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $successPartner]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $successPartner = SuccessPartner::find($id);
        if (!$successPartner) {
            return response()->json(['success' => false, 'message' => 'Record not found.'], 404);
        }

        // Update name if provided
        $successPartner->name = $request->name;

        // Update logo if provided
        if ($request->hasFile('logo')) {
            Storage::delete('public/logos/' . $successPartner->logo);
            $logoPath = $request->file('logo')->store('successPartner');
            $successPartner->logo = basename($logoPath);
        }

        $successPartner->save();

        return response()->json(['success' => true, 'data' => $successPartner]);
    }

    public function destroy($id)
    {
        $successPartner = SuccessPartner::find($id);
        if (!$successPartner) {
            return response()->json(['success' => false, 'message' => 'Record not found.'], 404);
        }

        // Delete associated logo file
        Storage::delete('public/logos/' . $successPartner->logo);

        $successPartner->delete();

        return response()->json(['success' => true]);
    }

    public function viewImage(Request $request)
    {
        try {
            $successPartner = SuccessPartner::find($request->id);
            if (!$successPartner) {
                return response()->json(['error' => 'Success partner not found'], 404);
            }
            $imagePath =  $successPartner->logo;
            if (!Storage::exists($imagePath)) {
                return response()->json(['error' => 'Image not found'], 404);
            }
            return response()->file(storage_path('app/' . $imagePath), [
                'Content-Type' => Storage::mimeType($imagePath),
                'Content-Disposition' => 'inline',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch image'], 500);
        }
    }
}
