<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Dashboard\Comment;
use App\Models\Dashboard\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function comments($product_id){
        $product = Product::findOrFail($product_id);
        return view('dashboard.comments.index', compact('product'));
    }

    public function get_all_comments(Request $request , $product_id)
    {

        if ($request->ajax()) {
            $data = Comment::with('product')->select('comments.*')->where('product_id', $product_id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('dashboard.comments.btn.action', compact('data'));
                })

                ->rawColumns([])

                ->make(true);
        }
    }

    public function store_comments(Request $request){

        try {

             $validator = Validator::make($request->all(),
                [
                    'content' => 'required|string',
                    'user_id' => 'required|exists:users,id',
                    'product_id' => 'required|exists:products,id',
                ],
                [
                    'content.required' => 'محتوى التعليق مطلوب',
                    'content.string' => 'محتوى التعليق يجب أن يكون نصًا',
                    'user_id.required' => 'رقم المستخدم مطلوب',
                    'user_id.exists' => 'المستخدم غير موجود',
                    'product_id.required' => 'رقم المنتج مطلوب',
                    'product_id.exists' => 'المنتج غير موجود',
                ]
            );

            // التحقق الإضافي حسب النوع
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msg' => 'هناك أخطاء في الإدخال',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // نأخذ البيانات الأساسية
            $data = $request->all();

            // الحفظ
            $Comment = Comment::create($data);

            if ($Comment) {
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

    public function destroy_comments(Request $request){

        try {

            $Comment = Comment::find($request->id);
            $Comment->delete();
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
