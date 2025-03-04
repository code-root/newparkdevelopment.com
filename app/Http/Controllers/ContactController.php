<?php

namespace App\Http\Controllers;

use App\Models\App\Page;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{



    public function store(Request $request)
    {
        $request->validate([
            'contact-name' => 'required|string|max:255',
            'contact-email' => 'required|email|max:255',
            'contact-phone' => 'nullable|string|max:20',
            'contact-message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->input('contact-name'),
            'email' => $request->input('contact-email'),
            'phone' => $request->input('contact-phone'),
            'message' => $request->input('contact-message'),
        ]);

        return [
            'success',
            'Your message has been sent successfully.'
        ];
    }


    public function index()
    {
        $contacts = Contact::all();
        $page = Page::where('status' , 'site')->limit(6)->latest()->get();

        return view('dashboard.contacts.index', compact('contacts' , 'page'));
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('success', 'Contact deleted successfully.');
    }

}
