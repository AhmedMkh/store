<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('permissions.index', compact('roles'));
    }

    public function get_all_role(Request $request){
        if ($request->ajax()) {
            $data = Role::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('dashboard.roles.btn.action', compact('data'));
                })


                ->make(true);
        }
    }
}
