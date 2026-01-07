<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function categories(){

        return view('dashboard.categories.index');
    }

    public function get_all_categories(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->editColumn('name', function ($data) {
                    return '<span style="color:black">'.$data->name.'</span>';
                })

                ->addColumn('status', function ($data) {
                    return view('dashboard.categories.btn.action2', compact('data'));
                })



                ->addColumn('action', function ($data) {
                    return view('dashboard.categories.btn.action', compact('data'));
                })



                ->rawColumns(['name'])

                ->make(true);
        }
    }

    public function store_categories(Request $request){

        try {

            $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                // 'slug' => 'required|unique:categories,slug',


            ],
            [
                'name.required' => 'هذا الاسم مطلوب',
                // 'slug.required' => 'هذا الاسم مطلوب',
                // 'slug.unique' => 'هذا الاسم مستخدم من قبل',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages()
            ], 422);
        }

            $category = Category::create($request->all());
            // $category = new Category();
            // $category ->name                  = $request->name;
            // $category ->slug                  = $request->slug;
            // $category ->status                = $request->status;


            // $category -> save();



            if ($category) {
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

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }


    }

    public function update_categories(Request $request){

        try {

            $request->validate([
                'name' => 'required',
                'slug' => 'nullable|unique:categories,slug,' . $request->id,
            ], [
                'name.required' => 'هذا الاسم مطلوب',
                'slug.unique' => 'هذا الاسم مستخدم من قبل',
            ]);


            $category = Category::findorFail($request->id);

            $category->update($request->all());
            // $category->name            = $request->name;
            // $category->slug            = $request->slug;
            // $category->status            = $request->status;
            // $category->save();

            if ($category) {
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

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }

    }

    public function destroy_categories(Request $request){

        try {

            $category = Category::find($request->id);
            $category->delete();
            return response()->json([
                'status' => true,
                'msg' => 'deleted Successfully',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }


    }

    public function is_view_categories(Request $request){

        try {
            $validator = Validator::make($request->all(),
            [
                'id' => 'required|integer|exists:categories,id',
            ],
            [
                'id.required' => 'ال id مطلوب' ,
                'id.integer' => 'ال id يجب ان يكون رقم صحيح',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages()
            ], 422);
        }

                $category = Category::find($request->id);
                // return 'MOHAMMED';

                $category->status = $category->status == 'active' ? 'inactive' : 'active';

                $category->save();

                return response()->json([
                    'status' => true,
                    'msg' => 'تم التعديل بنجاح.',
                ]);

            } catch (\Exception $e) {

                return response()->json([
                    'status' => false,
                    'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                    'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
                ], 500);
            }

    }



}
