<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Coupon;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function coupons(){

        return view('dashboard.coupons.index');
    }

    public function get_all_coupons(Request $request)
    {
        if ($request->ajax()) {
            $data = Coupon::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->editColumn('code', function ($data) {
                    return '<span style="color:black">'.$data->code.'</span>';
                })

                ->addColumn('action', function ($data) {
                    return view('dashboard.coupons.btn.action', compact('data'));
                })



                ->rawColumns(['code'])

                ->make(true);
        }
    }

    public function store_coupons(Request $request){

        try {
        $validator = Validator::make($request->all(), [
            'usage_limit' => 'required|integer|min:1',
            'expiry_date' => 'nullable|date',
            'type'        => 'required|in:fixed,percentage',
            'discount_amount' => [
                'required',
                'numeric',
                'min:0',
                // دالة تحقق مخصصة (Closure)
                function ($attribute, $value, $fail) use ($request) {
                    // 1. فحص حالة النسبة المئوية
                    if ($request->type === 'percentage' && $value > 100) {
                        $fail('النسبة المئوية يجب أن لا تتجاوز 100.');
                    }

                    // 2. فحص حالة المبلغ الثابت (اختياري)
                    if ($request->type === 'fixed' && $value > 999999) {
                        $fail('مبلغ الخصم الثابت كبير جداً.');
                    }
                },
            ],
        ], [
            'discount_amount.required' => 'مقدار الخصم مطلوب',
            'discount_amount.numeric'  => 'مقدار الخصم يجب ان يكون رقم',
            'usage_limit.required'     => 'حد الاستخدام مطلوب',
            'usage_limit.integer'      => 'حد الاستخدام يجب ان يكون رقم صحيح',
            'usage_limit.min'          => 'حد الاستخدام يجب ان يكون اكبر من صفر',
            'expiry_date.date'         => 'تاريخ الانتهاء غير صالح',
            'type.required'            => 'نوع الكوبون مطلوب',
            'type.in'                  => 'نوع الكوبون غير صالح',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages()
            ], 422);
        }


            $Coupon = Coupon::create($request->all());
            // $Coupon = new Coupon();
            // $Coupon ->name                  = $request->name;
            // $Coupon ->slug                  = $request->slug;
            // $Coupon ->status                = $request->status;


            // $Coupon -> save();



            if ($Coupon) {
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

    public function update_coupons(Request $request){

        try {
        $validator = Validator::make($request->all(), [
            'usage_limit' => 'required|integer|min:1',
            'expiry_date' => 'nullable|date',
            'type'        => 'required|in:fixed,percentage',
            'discount_amount' => [
                'required',
                'numeric',
                'min:0',
                // دالة تحقق مخصصة (Closure)
                function ($attribute, $value, $fail) use ($request) {
                    // 1. فحص حالة النسبة المئوية
                    if ($request->type === 'percentage' && $value > 100) {
                        $fail('النسبة المئوية يجب أن لا تتجاوز 100.');
                    }

                    // 2. فحص حالة المبلغ الثابت (اختياري)
                    if ($request->type === 'fixed' && $value > 999999) {
                        $fail('مبلغ الخصم الثابت كبير جداً.');
                    }
                },
            ],
        ], [
            'discount_amount.required' => 'مقدار الخصم مطلوب',
            'discount_amount.numeric'  => 'مقدار الخصم يجب ان يكون رقم',
            'usage_limit.required'     => 'حد الاستخدام مطلوب',
            'usage_limit.integer'      => 'حد الاستخدام يجب ان يكون رقم صحيح',
            'usage_limit.min'          => 'حد الاستخدام يجب ان يكون اكبر من صفر',
            'expiry_date.date'         => 'تاريخ الانتهاء غير صالح',
            'type.required'            => 'نوع الكوبون مطلوب',
            'type.in'                  => 'نوع الكوبون غير صالح',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages()
            ], 422);
        }

            $Coupon = Coupon::findorFail($request->id);
            $Coupon->update($request->all());
            // $Coupon->name            = $request->name;
            // $Coupon->slug            = $request->slug;
            // $Coupon->status            = $request->status;
            // $Coupon->save();

            if ($Coupon) {
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

    public function destroy_coupons(Request $request){

        try {

            $Coupon = Coupon::find($request->id);
            $Coupon->delete();
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
