<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Dashboard\Subcategory;
use App\Models\Dashboard\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    public function subcategories(){

        $categories = Category::all();

        return view('dashboard.subcategories.index',compact('categories'));
    }

    public function get_all_subcategories(Request $request)
    {
        if ($request->ajax()) {
            $data = Subcategory::with('category')->select('subcategories.*')->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('category', function ($row) {
                return $row->category ? $row->category->name : '-';
                })

                ->editColumn('name', function ($data) {
                    return '<span style="color:black">'.$data->name.'</span>';
                })

                ->addColumn('status', function ($data) {
                    return view('dashboard.subcategories.btn.action2', compact('data'));
                })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.subcategories.btn.action', compact('data'));
                })



                ->rawColumns(['image','name'])

                ->make(true);
        }
    }

    public function store_subcategories(Request $request){

        try {
            
             $validator = Validator::make($request->all(),
                [ 
                    'name' => 'required|string|max:255',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'status' => 'required|in:active,inactive',
                    'category_id' => 'required|exists:categories,id',
                    'slug' => 'nullable|unique:subcategories,slug',
                ],
                [
                    'name.required' => 'هذا الاسم مطلوب',
                    'image.image' => 'يجب أن تكون الصورة من نوع صورة',
                    'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                    'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
                    'status.required' => 'حالة القسم الفرعي مطلوبة',
                    'category_id.required' => 'رقم القسم الرئيسي مطلوب',
                    'category_id.exists' => 'القسم الرئيسي غير موجود',
                    'slug.unique' => 'هذا الرابط مستخدم من قبل',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }


            // 1. نأخذ كل البيانات ما عدا الصورة (لأننا سنعالجها يدوياً)
            $data = $request->except('image');

            // 2. معالجة الصورة إذا وجدت
            if ($request->hasFile('image')) {
                $image_url = \Illuminate\Support\Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                
                // نقل الصورة للمجلد
                $request->image->move(public_path('attachments/subcategories'), $image_url);

                // 3. إضافة اسم الصورة للمصفوفة
                $data['image'] = $image_url;
            }

            // 4. الحفظ بسطر واحد باستخدام المصفوفة المجهزة
            $subcategory = Subcategory::create($data);



            if ($subcategory) {
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

    public function update_subcategories(Request $request){

        try {

                $validator = Validator::make($request->all(),
                    [ 
                        'name' => 'required|string|max:255',
                        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                        'status' => 'required|in:active,inactive',
                        'category_id' => 'required|exists:categories,id',
                        'slug' => 'nullable|unique:subcategories,slug,'.$request->id,
                    ],
                    [
                        'name.required' => 'هذا الاسم مطلوب',
                        'image.image' => 'يجب أن تكون الصورة من نوع صورة',
                        'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                        'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
                        'status.required' => 'حالة القسم الفرعي مطلوبة',
                        'category_id.required' => 'رقم القسم الرئيسي مطلوب',
                        'category_id.exists' => 'القسم الرئيسي غير موجود',
                        'slug.unique' => 'هذا الرابط مستخدم من قبل',
                    ]
                );
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors()->messages()
                    ], 422);
                }

            $subcategory = Subcategory::findorfail($request->id);

            $data = $request->except('image');
            if ($request->hasFile('image')) {
                $image_url = \Illuminate\Support\Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('attachments/subcategories'), $image_url);
                $data['image'] = $image_url;
            }

            $subcategory->update($data);

            if ($subcategory) {
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

    public function destroy_subcategories(Request $request){

        try {

            $subcategory = Subcategory::find($request->id);
            $subcategory->delete();
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

    public function is_view_subcategories(Request $request){

        try {
                 $validator = Validator::make($request->all(),
                [
                    'id' => 'required|exists:subcategories,id',
                ],
                [
                    'id.required' => 'رقم القسم الفرعي مطلوب',
                    'id.exists' => 'القسم الفرعي غير موجود',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

                $subcategory = Subcategory::find($request->id);

                $subcategory->status = $subcategory->status === 'active' ? 'inactive' : 'active';

                $subcategory->save();

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
