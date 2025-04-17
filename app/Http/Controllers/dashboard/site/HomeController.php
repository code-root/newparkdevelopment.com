<?php
namespace App\Http\Controllers\dashboard\site;
use App\Http\Controllers\Controller;
use App\Models\site\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $messages = Contact::latest()->paginate(10);
        return view('dashboard.home', compact('messages'));
    }
}
