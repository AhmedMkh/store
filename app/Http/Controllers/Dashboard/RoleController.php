<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    // function __construct()
        //           {
        //             $this->middleware('permission:قائمة المستخدمين', ['only' => ['index']]);
        //             $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
        //             $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
        //             $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    //      }


    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->get();
        return view('dashboard.roles.index',compact('roles'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $permissions = \App\Models\Dashboard\Permission::where('parent',0)->with('childrens')->get();
        return view('dashboard.roles.create',compact('permissions'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);


        $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $request->input('permission'))->pluck('name');


        $role->syncPermissions($permissions);

        if ($role) {
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
    }


    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();
        return view('dashboard.roles.show',compact('role','rolePermissions'));
    }


    public function edit($id)
    {
        $id33 = $id;
        $role = Role::find($id);
        $permissions = \App\Models\Dashboard\Permission::where('parent',0)->with('childrens')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('dashboard.roles.edit',compact('role','permissions','rolePermissions','id33'));
    }


    public function update_rolee(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($request->id_passing);
        $role->name = $request->input('name');
        $role->save();

        $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $request->input('permission'))->pluck('name');
        $role->syncPermissions($permissions);

        if ($role) {
            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
    }


    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('dashboard.roles.index')
        ->with('success','Role deleted successfully');
    }
}
