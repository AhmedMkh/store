<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Dashboard\ProductAttachment;
use App\Models\Dashboard\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductAttachmentController extends Controller
{
    public function product_attachments($product_id){
        $product = Product::findOrFail($product_id);
        return view('dashboard.product_attachments.index', compact('product'));
    }

    public function get_all_product_attachments(Request $request , $product_id)
    {

        if ($request->ajax()) {
            $data = ProductAttachment::with('product')->select('product_attachments.*')->where('product_id', $product_id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

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
                    'image' => 'required_if:type,image|nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
                    'video' => 'required_if:type,video|nullable|url',
                ],
                [
                    'product_id.required' => 'رقم المنتج مطلوب',
                    'product_id.exists' => 'المنتج غير موجود',
                    'type.required' => 'نوع المرفق مطلوب',
                    'type.in' => 'نوع المرفق غير صالح',
                    'image.required_if' => 'الصورة مطلوبة',
                    'image.image' => 'يجب أن تكون الملف صورة',
                    'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                    'image.max' => 'حجم الصورة يجب أن يكون أقل من 4 ميجابايت',
                    'video.required_if' => 'رابط الفيديو مطلوب',
                    'video.url' => 'رابط الفيديو يجب أن يكون رابطًا صحيحًا',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            // نأخذ البيانات الأساسية
            $data = $request->only('product_id', 'type');

            // معالجة المرفق حسب النوع
            if ($request->type === 'image' && $request->hasFile('image')) {
                $image_url = \Illuminate\Support\Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('attachments/product_attachments'), $image_url);
                $data['attachment'] = $image_url;
            } elseif ($request->type === 'video' && $request->video) {
                $data['attachment'] = $request->video;
            }

            // الحفظ
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


}
