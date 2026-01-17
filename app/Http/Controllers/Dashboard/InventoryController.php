<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Inventory;
use App\Models\Dashboard\Product;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function inventory(){

        $products = Product::all();

        return view('dashboard.inventory.index', compact('products'));
    }

    public function get_all_inventory(Request $request)
    {
        if ($request->ajax()) {
            $data = Inventory::with('Product')->select('inventory.*')->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->editColumn('name', function ($data) {
                    return '<span style="color:black">'.$data->name.'</span>';
                })

                ->addColumn('Product', function ($row) {
                return $row->Product ? $row->Product->name : '-';
                })

                ->addColumn('action', function ($data) {
                    return view('dashboard.inventory.btn.action', compact('data'));
                })



                ->rawColumns(['name'])

                ->make(true);
        }
    }

    public function store_inventory(Request $request){

        try {

            $validator = Validator::make($request->all(),
            [

                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:0',
                'expiration_date' => 'nullable|date',

            ],
            [
                'product_id.required' => 'رقم المنتج مطلوب',
                'product_id.exists' => 'المنتج غير موجود',
                'quantity.required' => 'الكمية مطلوبة',
                'quantity.integer' => 'يجب أن تكون الكمية رقم صحيح',
                'quantity.min' => 'يجب أن تكون الكمية صفر أو أكثر',
                'expiration_date.date' => 'تاريخ انتهاء الصلاحية غير صالح',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages()
            ], 422);
        }

            $Inventory = Inventory::create($request->all());
            // $Inventory = new Inventory();
            // $Inventory ->name                  = $request->name;
            // $Inventory ->slug                  = $request->slug;
            // $Inventory ->status                = $request->status;


            // $Inventory -> save();



            if ($Inventory) {
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

    public function update_inventory(Request $request){

        try {

            $request->validate([
                'id' => 'required|exists:inventory,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:0',
                'expiration_date' => 'nullable|date',
            ], [
                'id.required' => 'رقم الجرد مطلوب',
                'id.exists' => 'الجرد غير موجود',
                'product_id.required' => 'رقم المنتج مطلوب',
                'product_id.exists' => 'المنتج غير موجود',
                'quantity.required' => 'الكمية مطلوبة',
                'quantity.integer' => 'يجب أن تكون الكمية رقم صحيح',
                'quantity.min' => 'يجب أن تكون الكمية صفر أو أكثر',
                'expiration_date.date' => 'تاريخ انتهاء الصلاحية غير صالح',
            ]);


            $Inventory = Inventory::findorFail($request->id);

            $Inventory->update($request->all());
            // $Inventory->name            = $request->name;
            // $Inventory->slug            = $request->slug;
            // $Inventory->status            = $request->status;
            // $Inventory->save();

            if ($Inventory) {
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

    public function destroy_inventory(Request $request){

        try {

            $Inventory = Inventory::find($request->id);
            $Inventory->delete();
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
