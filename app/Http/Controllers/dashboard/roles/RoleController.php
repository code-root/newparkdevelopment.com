<?php

namespace App\Http\Controllers\dashboard\roles;

use App\Enums\ModelsEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    //      $this->middleware('permission:roles-list|roles-create|roles-edit|roles-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:roles-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $permissionsData = [];
        $models = ModelsEnum::getAllModels();
        foreach ($models as $model) {
            $permissions = ['read', 'write', 'create'];
            $modelPermissions = [];
            foreach ($permissions as $permission) {
                $permissionName = $permission;
                // $permissionName = $permission . '_' . $model;
                $existingPermission = Permission::where('name', $permission . '-' . $model)->where('guard_name', 'web')->first();

                // إذا كانت الأذونة موجودة، قم بإضافة معلوماتها إلى المصفوفة
                if ($existingPermission) {
                    $modelPermissions[] = [
                        'name' => $existingPermission->name,
                        'id' => $existingPermission->id,
                        'description' => $permission, // قد تحتاج إلى إضافة حقل description في جدول الأذونات
                        'isChecked' => true, // افتراضيًا يتم تحديد الخانة
                    ];
                } else {
                    // إذا لم تكن الأذونة موجودة، قم بإضافة معلومات الأذونة بدون تحديد الخانة
                    $modelPermissions[] = [
                        'id' => '',
                        'name' => $permissionName,
                        'description' => $permission,
                        'isChecked' => true,
                    ];
                }
            }

            $permissionsData[$model] = $modelPermissions;
        }
        $rolesWithUsers = Role::with('users')->get();
        $roles = Role::orderBy('id','DESC')->get();
        return view('dashboard.roles.index',compact('roles' , 'permissionsData' , 'rolesWithUsers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('dashboard.roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'modalRoleName' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->input('modalRoleName')]);

        // التحقق مما إذا كانت الأذونات معينة
        if (!empty($request->input('permissions'))) {
            $permissions = $request->input('permissions');

            // إضافة الأذونات إلى الدور
            foreach ($permissions as $key => $value) {
                $existingPermission = Permission::find($key);

                if ($existingPermission) {
                    $role->givePermissionTo($existingPermission->name);
                }
            }
        }

        return [
            'msg' => 'Role added successfully'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('dashboard.roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('dashboard.roles.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        foreach ($request->input('permission') as $key => $value) {
            $existingPermission = Permission::find($value);
            if ($existingPermission) {
                $role->givePermissionTo($existingPermission->name);
            }
        }
        return [
            'msg' => 'Role added successfully'
        ];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->back()
                        ->with('success','Role deleted successfully');
    }
}
