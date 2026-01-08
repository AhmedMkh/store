<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Dashboard\Product;
use App\Models\Dashboard\Subcategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function products(){

        $subcategories = Subcategory::all();

        return view('dashboard.products.index',compact('subcategories'));
    }

    public function get_all_products(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('subcategory')->select('products.*')->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('subcategory', function ($row) {
                return $row->subcategory ? $row->subcategory->name : '-';
                })

                ->editColumn('name', function ($data) {
                    return '<span style="color:black">'.$data->name.'</span>';
                })

                ->addColumn('status', function ($data) {
                    return view('dashboard.products.btn.action2', compact('data'));
                })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.products.btn.action', compact('data'));
                })



                ->rawColumns(['image','name'])

                ->make(true);
        }
    }

    public function store_products(Request $request){

        try {
            
             $validator = Validator::make($request->all(),
                [ 
                    'name' => 'required|string|max:255',
                    'subcategory_id' => 'required|exists:subcategories,id',
                    'description' => 'nullable|string',
                    'price' => 'required|numeric|min:0',
                    'discount_price' => 'nullable|numeric|min:0|lt:price',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'status' => 'required|in:active,inactive',
                    'slug' => 'nullable|unique:products,slug',
                ],
                [
                    'name.required' => 'هذا الاسم مطلوب',
                    'image.image' => 'يجب أن تكون الصورة من نوع صورة',
                    'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                    'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
                    'status.required' => 'حالة القسم الفرعي مطلوبة',
                    'subcategory_id.required' => 'رقم القسم الفرعي مطلوب',
                    'subcategory_id.exists' => 'القسم الفرعي غير موجود',
                    'description.nullable' => 'الوصف يجب أن يكون نصًا',
                    'price.required' => 'السعر مطلوب',
                    'price.numeric' => 'السعر يجب أن يكون رقمًا',
                    'price.min' => 'السعر يجب أن يكون أكبر من 0',
                    'discount_price.nullable' => 'سعر الخصم يجب أن يكون رقمًا',
                    'discount_price.numeric' => 'سعر الخصم يجب أن يكون رقمًا',
                    'discount_price.min' => 'سعر الخصم يجب أن يكون أكبر من 0',
                    'discount_price.lt' => 'سعر الخصم يجب أن يكون أقل من السعر الأصلي',
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
                $request->image->move(public_path('attachments/products'), $image_url);

                // 3. إضافة اسم الصورة للمصفوفة
                $data['image'] = $image_url;
            }

            // 4. الحفظ بسطر واحد باستخدام المصفوفة المجهزة
            $product = Product::create($data);



            if ($product) {
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

    public function update_products(Request $request){

        try {

                $validator = Validator::make($request->all(),
                    [ 
                        'id' => 'required|exists:products,id',
                        'name' => 'required|string|max:255',
                        'subcategory_id' => 'required|exists:subcategories,id',
                        'description' => 'nullable|string',
                        'price' => 'required|numeric|min:0',
                        'discount_price' => 'nullable|numeric|min:0|lt:price',
                        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                        'status' => 'required|in:active,inactive',
                        'slug' => 'nullable|unique:products,slug,'.$request->id,
                    ],
                    [
                        'id.required' => 'رقم المنتج مطلوب',
                        'id.exists' => 'المنتج غير موجود',
                        'name.required' => 'هذا الاسم مطلوب',
                        'image.image' => 'يجب أن تكون الصورة من نوع صورة',
                        'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                        'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
                        'status.required' => 'حالة القسم الفرعي مطلوبة',
                        'subcategory_id.required' => 'رقم القسم الفرعي مطلوب',
                        'subcategory_id.exists' => 'القسم الفرعي غير موجود',
                        'description.nullable' => 'الوصف يجب أن يكون نصًا',
                        'price.required' => 'السعر مطلوب',
                        'price.numeric' => 'السعر يجب أن يكون رقمًا',
                        'price.min' => 'السعر يجب أن يكون أكبر من 0',
                        'discount_price.nullable' => 'سعر الخصم يجب أن يكون رقمًا',
                        'discount_price.numeric' => 'سعر الخصم يجب أن يكون رقمًا',
                        'discount_price.min' => 'سعر الخصم يجب أن يكون أكبر من 0',
                        'discount_price.lt' => 'سعر الخصم يجب أن يكون أقل من السعر الأصلي',
                        'slug.unique' => 'هذا الرابط مستخدم من قبل',
                    ]
                );
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors()->messages()
                    ], 422);
                }

            $product = Product::findorfail($request->id);

            $data = $request->except('image');
            if ($request->hasFile('image')) {
                $image_url = \Illuminate\Support\Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('attachments/products'), $image_url);
                $data['image'] = $image_url;
            }

            $product->update($data);

            if ($product) {
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

    public function destroy_products(Request $request){

        try {

            $product = Product::find($request->id);
            $product->delete();
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

    public function is_view_products(Request $request){

        try {
                 $validator = Validator::make($request->all(),
                [
                    'id' => 'required|exists:products,id',
                ],
                [
                    'id.required' => 'رقم المنتج مطلوب',
                    'id.exists' => 'المنتج غير موجود',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

                $product = Product::find($request->id);

                $product->status = $product->status === 'active' ? 'inactive' : 'active';

                $product->save();
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
