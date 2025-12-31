<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'email'      => 'required|unique:users,email',
            'password'   => 'required',
            'fcm_token'  => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => false,
                'message' => 'Make sure that the information is correct and fill in all fields',
                'errors' => $validator->errors(),
                'code' => 422
            ]);
        }

        DB::beginTransaction();
        try {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->fcm_token = $request->fcm_token;
            $user->save();


            $accessToken = $user->createToken($user->email)->accessToken;

            DB::commit();

            return response([

                'code'=> 200,
                'status' => true,
                'message'=>'registration successfully',
                'user' => $user,
                'access_token' => $accessToken

            ]);


        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {

      $loginData = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'fcm_token'    => 'required',
        ]);

          if ($loginData->fails()) {
            $errors = $loginData->errors();

            return response([
                'status'=>false,
                'message'=>'Make sure that the information is correct and fill in all fields',
                'errors'=>$errors,
                'code'=>422
            ]);
        }


        $user = User::where('email',$request->email)->first();


        if($user)
        {

            if (!Hash::check($request->password, $user->password)) {

                return response()->json(
                    ["errors"=>[
                        "password"=>[
                         "Invalid Password!"
                        ]
                    ],
                    "status"=>false,
                    'code' => 404,
                ]);
            }


            $user->fcm_token =  $request->fcm_token;

            $user->save();


            $accessToken =     $user->createToken($user->email)->accessToken;

            return response([
                'code' => 200,
                'status' => true,
                'message' => 'login Successfully',
                'user' => $user,
                'access_token' => $accessToken
            ]);
        }
        else
        {

            return response()->json(
                ["errors"=>[
                    "email"=>[
                      "البيانات غير صحيحة"
                    ]
                ],
                "status"=>false,
                'code' => 404,
            ]);
        }

    }


    public function logout(){

        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user()->token();
            $user->revoke();
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'تم تسجيل الخروج بنجاح',

            ]);
        }else{
            return response()->json([
                'code' => 401,
                'status' => false,
                'message' => 'انت غير مسجل دخول',

            ]);
        }

    }


    public function my_profile(){

        $user = User::where('id',Auth::guard('api')->user()->id)->first();

        if(!$user){

            return response()->json([
                'code' => 404,
                'status' => false,
                'message' => 'Not Authnticate',

            ]);

        }else{
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'fetch data succsessfully',
                'data' => $user
            ]);

        }
    }



}
