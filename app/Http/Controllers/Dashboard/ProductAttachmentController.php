<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Dashboard\ProductAttachment;
use App\Models\Dashboard\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductAttachmentController extends Controller
{
    public function product_attachments(){

        return view('dashboard.product_attachments.index');
    }

    public function get_all_product_attachments(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductAttachment::with('product')->select('product_attachments.*')->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('product', function ($row) {
                return $row->product ? $row->product->name : '-';
                })

                ->editColumn('name', function ($data) {
                    return '<span style="color:black">'.$data->name.'</span>';
                })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.product_attachments.btn.action', compact('data'));
                })

                ->rawColumns(['image','name'])

                ->make(true);
        }
    }

    public function store_product_attachments(Request $request){

        try {
            
             $validator = Validator::make($request->all(),
                [ 
                    'product_id' => 'required|exists:products,id',
                    'type' => 'required|in:image,video',
                    'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ],
                [
                    'product_id.required' => 'رقم المنتج مطلوب',
                    'product_id.exists' => 'المنتج غير موجود',
                    'type.required' => 'نوع المرفق مطلوب',
                    'type.in' => 'نوع المرفق غير صالح',
                    'path.required' => 'الصورة مطلوبة',
                    'path.image' => 'يجب أن تكون الصورة من نوع صورة',
                    'path.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                    'path.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
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
                $request->image->move(public_path('attachments/product_attachments'), $image_url);

                // 3. إضافة اسم الصورة للمصفوفة
                $data['image'] = $image_url;
            }

            // 4. الحفظ بسطر واحد باستخدام المصفوفة المجهزة
            $ProductAttachment = ProductAttachment::create($data);



            if ($ProductAttachment) {
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

    public function update_product_attachments(Request $request){

        try {

                $validator = Validator::make($request->all(),
                    [ 
                        'name' => 'required|string|max:255',
                        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                        'status' => 'required|in:active,inactive',
                        'category_id' => 'required|exists:categories,id',
                        'slug' => 'nullable|unique:product_attachments,slug,'.$request->id,
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

            $ProductAttachment = ProductAttachment::findorfail($request->id);

            $data = $request->except('image');
            if ($request->hasFile('image')) {
                $image_url = \Illuminate\Support\Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('attachments/product_attachments'), $image_url);
                $data['image'] = $image_url;
            }

            $ProductAttachment->update($data);

            if ($ProductAttachment) {
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

    public function destroy_product_attachments(Request $request){

        try {

            $ProductAttachment = ProductAttachment::find($request->id);
            $ProductAttachment->delete();
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

    public function is_view_product_attachments(Request $request){

        try {
                 $validator = Validator::make($request->all(),
                [
                    'id' => 'required|exists:product_attachments,id',
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

                $ProductAttachment = ProductAttachment::find($request->id);

                $ProductAttachment->status = $ProductAttachment->status === 'active' ? 'inactive' : 'active';

                $ProductAttachment->save();

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
