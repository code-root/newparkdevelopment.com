<?php
namespace App\Http\Controllers\dashboard\site;
use App\Http\Controllers\Controller;
use App\Models\ProjectRequest;
use App\Models\Project;
use App\Models\App\DeviceUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $project = Project::count();
        $deviceOrders = DeviceUser::select('device_type', DB::raw('count(*) as total'))->groupBy('device_type')->get();
        $filter = $request->input('filter', 'month');
        $date = Carbon::now();
        $startDate = $filter == 'month' ? $date->startOfMonth() : $date->startOfDay();
        $endDate = Carbon::now();


        return view('dashboard.home', compact('project', 'deviceOrders', 'filter'));
    }
}
