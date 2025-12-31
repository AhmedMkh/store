<?php

namespace App\Http\Controllers\Dashboard;


use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Models\Dashboard\Admin;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function admins()
    {

        return view('dashboard.admins.index');
    }



    public function get_all_admins(Request $request){
        $data = Admin::where('id','!=',3)->orderBy('id','desc');
        return Datatables::of($data)

            ->addIndexColumn()

            ->editColumn('status', function ($data) {


              $e = '<p style="color:green">مفعل</p>';
              $d = '<p style="color:red">غير مفعل</p>';

                return $data->status == "0" ? $d: $e;
            })




            ->addColumn('action', function ($data) {
                return view('dashboard.admins.btn.action', compact('data'));
            })

            ->rawColumns(['status'])

            ->make(true);
    }




    public function store_admins(Request $request)
    {
        $this->validate($request, [
            'name'       => 'required',
            'email'      => 'required|email|unique:admins,email',
            'password'   => 'required',
            'roles_name' => 'required'
            ]);

            $input = $request->all();


            $input['password'] = Hash::make($input['password']);

            $user = Admin::create($input);
            $user->assignRole($request->input('roles_name'));


            if ($user) {
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


    public function update_admins(Request $request)
    {


        $id = $request->id;


        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            // 'password' => 'required',
            'roles_name' => 'required',
            'status' => 'required'
        ]);

        $input = $request->all();

        $admin = Admin::where('id',$id)->first();


        if(isset($request->password)){
            if($request->password == $admin->password){
                  $input['password'] = $admin->password;
            }else{
                $input['password'] = bcrypt($request->password);
            }
     }

        $admin->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $admin->assignRole($request->input('roles_name'));


        if ($admin) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تمت التعديل بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
                ]);
            }
    }


     public function destroy_admins(Request $request)
    {

        $user2 = Admin::find($request->id);
        $user2->delete();

        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
    }

    public function myprofile()
    {
        return view('dashboard.admins.settings');
    }

    public function myprofile_update(Request $request)
    {


        $id2 = $request->id;

        $request->validate([
            'email' => 'required|email|unique:admins,email,' . $id2,
            'password' => 'required|confirmed|min:6',
        ]);


        $admins = Admin::findorFail($request->id);

        $admins->name        = $request->nameauth;
        $admins->email       = $request->email;

        // عشان اذا عدلت على اي  حقل غير الباسورد ..يضل الباسورد زي ما هو
        if ($request->password == $admins->password) {
            $admins->password = $admins->password;
        } else {
            $admins->password    = bcrypt($request->password);
        }

        $admins->save();


        if ($admins) {
            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل التعديل برجاء المحاوله مجددا',
            ]);
        }
    }


}
