<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Dashboard\Student;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function students(){

        return view('dashboard.students.index');
    }

    public function get_all_students(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->editColumn('name', function ($data) {
                    return '<span style="color:black">'.$data->name.'</span>';
                })

                ->addColumn('is_view', function ($data) {
                    return view('dashboard.students.btn.action2', compact('data'));
                })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . env('APP_URL') . '/attachments/students/' . $data->image . '" alt="" style="width:30%">';
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.students.btn.action', compact('data'));
                })



                ->rawColumns(['image','name'])

                ->make(true);
        }
    }

    public function store_students(Request $request){

        try {
            $request->validate([
                'name' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'هذا الاسم مطلوب',
                'image.required' => 'الصورة مطلوبة',
                'image.image' => 'يجب أن تكون الصورة من نوع صورة',
                'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
            ]);



            $user = new Student();
            $user ->name                  = $request->name;

            if ($request->hasFile('image')) {


                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();

                $base_url = $image_url;

                $user -> image   = $base_url;

                $request->image-> move(public_path('attachments/students'), $image_url);

            }



            $user -> save();



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

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }


    }

    public function update_students(Request $request){

        try {

            $request->validate([
                'name' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'هذا الاسم مطلوب',
                'image.required' => 'الصورة مطلوبة',
                'image.image' => 'يجب أن تكون الصورة من نوع صورة',
                'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
            ]);


            $stud = Student::findorFail($request->id);


            $stud->name            = $request->name;

            if ($request->hasFile('image')) {


                // مسار الصورة القديمة
                $oldImagePath = public_path('attachments/students/' . $stud->image);

                // حذف الصورة القديمة إذا كانت موجودة
                if (file_exists($oldImagePath) && $stud->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $base_url = $image_url;

                $stud -> image   = $base_url;

                $request->image-> move(public_path('attachments/students'), $image_url);

            }

            $stud->save();

            if ($stud) {
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

    public function destroy_students(Request $request){

        try {

            $stud = Student::find($request->id);
            $stud->delete();
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

    public function is_view_students(Request $request){

        try {
                $validatedData = $request->validate([
                    'id' => 'required|integer|exists:students,id',
                ], [
                    'id.required' => 'رقم الطالب مطلوب.',
                    'id.integer' => 'رقم الطالب يجب أن يكون رقمًا صحيحًا.',
                    'id.exists' => 'الطالب غير موجود في قاعدة البيانات.',
                ]);

                $student = Student::find($validatedData['id']);

                $student->is_view = !$student->is_view;

                $student->save();

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



    // هنا يوجد اضافة الوان و تصنيفات فرعية وصور متعددة بالنسبة للصور
    //  وتحديث الصور فقط هنا يزبط لل api    لانو حاطط ارجاع الصورة بالمسار كامل في المودل
    //في المنتجات اما الطلاب لا  api باختصار التعديلات بالنسبة للصور لل
    // public function add_product(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {

    //         // return $request->all();


    //         $new_product = new Product();
    //         $new_product->name = $request->name;
    //         $new_product->description = $request->description;
    //         $new_product->price_before = $request->price_before;
    //         $new_product->price_after = $request->price_after;
    //         $new_product->qty = $request->qty;
    //         $new_product->brand_id = $request->brand_id;
    //         $new_product->category_id = $request->category_id;
    //         $new_product->save();

    //         if ($request->hasFile('images')) {

    //               // إضافة الفاليديشن
    //             // $validator = Validator::make($request->all(), [
    //             //     'images' => 'required|array', // يجب أن يكون هناك مجموعة من الصور
    //             //     'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048', // التحقق من أن كل صورة هي ملف وصيغة معينة
    //             // ]);

    //             // // التحقق من الفاليديشن
    //             // if ($validator->fails()) {
    //             //     return response()->json(['error' => $validator->errors()], 400);
    //             // }

    //             $image_data = [];

    //             foreach ($request->file('images') as $image) {

    //                 // تأكد من أن الصورة ليست فارغة
    //                 if ($image && $image->isValid()) {

    //                     $image_url = Str::uuid() . '.' . $image->getClientOriginalExtension();
    //                     $image_data[] = [
    //                         'type' => 'image',
    //                         'product_id' => $new_product->id,
    //                         'image' => $image_url,
    //                     ];

    //                     // قم بتحريك الصورة إلى المسار المناسب
    //                     $image->move(public_path('attachments/products'), $image_url);
    //                 }
    //             }

    //             // إدخال الصور دفعة واحدة في قاعدة البيانات
    //             ProductImage::insert($image_data);
    //         }

    //         if ($request->has('sub_categories')) {

    //                 $sub_categories_data = [];

    //                 $sub_categories = json_decode($request->sub_categories);

    //                 foreach ($sub_categories as $sub_category) {

    //                     $sub_categories_data[] = [
    //                         'product_id' => $new_product->id,
    //                         'subcategory_id' => $sub_category,
    //                     ];
    //                 }

    //                 ProductSubCategory::insert($sub_categories_data); // إدخال الألوان دفعة واحدة

    //         }


    //         if ($request->has('colors')) {


    //             $color_data = [];
    //             $colors = json_decode($request->colors);
    //             foreach ($colors as $color) {
    //                 $color_data[] = [
    //                     'type' => 'color',
    //                     'product_id' => $new_product->id,
    //                     'color' => $color,
    //                 ];
    //             }

    //             ProductImage::insert($color_data); // إدخال الألوان دفعة واحدة

    //         }

    //         DB::commit();
    //         return response()->json(
    //             [
    //                 'message' => 'Product added successfully!',
    //                 'status' =>true
    //     ], 201);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(
    //             [
    //                 'error' => 'Failed to add product: ' . $e->getMessage(),
    //                 'status' =>false
    //             ], 500);
    //     }
    // }

    // public function update_product(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // العثور على المنتج
    //         $product = Product::with('images')->findOrFail($request->id);

    //         // تحديث بيانات المنتج
    //         $product->name = $request->name ?? $product->name;
    //         $product->description = $request->description ?? $product->description;
    //         $product->price_before = $request->price_before ?? $product->price_before;
    //         $product->price_after = $request->price_after ?? $product->price_after;
    //         $product->qty = $request->qty ?? $product->qty;
    //         $product->brand_id = $request->brand_id ?? $product->brand_id;
    //         $product->category_id = $request->category_id ?? $product->category_id;
    //         $product->save();

    //         // تحديث الصور
    //         if ($request->hasFile('images')) {

    //             $image_data = [];

    //             // جلب الصور القديمة من قاعدة البيانات
    //             $old_images = ProductImage::where('product_id', $product->id)->where('type', 'image')->get();

    //             // حذف الصور القديمة من ملف `public`
    //             foreach ($old_images as $old_image) {

    //                 // استخراج اسم الملف من الرابط
    //                 // $old_image->image هاي بترجع مسار الصورة بالكامل لانو بالمودل انا مرجع الصورة ترجع المسار بالكامل عشان هيك بستخرج الاسم
    //                 $filename = basename($old_image->image);

    //                  // إنشاء المسار المحلي الصحيح
    //                 $image_path = public_path('attachments/products/' . $filename);

    //                 if (file_exists($image_path)) {
    //                     unlink($image_path);
    //                 }
    //             }

    //             // حذف الصور القديمة من قاعدة البيانات
    //             ProductImage::where('product_id', $product->id)->where('type', 'image')->delete();

    //             // رفع الصور الجديدة
    //             foreach ($request->file('images') as $image) {
    //                 if ($image && $image->isValid()) {
    //                     $image_url = Str::uuid() . '.' . $image->getClientOriginalExtension();
    //                     $image_data[] = [
    //                         'type' => 'image',
    //                         'product_id' => $product->id,
    //                         'image' => $image_url,
    //                     ];
    //                     $image->move(public_path('attachments/products'), $image_url);
    //                 }
    //             }



    //             // إدخال الصور الجديدة في قاعدة البيانات
    //             ProductImage::insert($image_data);
    //         }


    //         // تحديث التصنيفات الفرعية
    //         if ($request->has('sub_categories')) {

    //             $sub_categories = json_decode($request->sub_categories);
    //             $sub_categories_data = [];

    //             foreach ($sub_categories as $sub_category) {


    //                 $sub_categories_data[] = [
    //                     'product_id' => $product->id,
    //                     'subcategory_id' => $sub_category,
    //                 ];

    //             }

    //             // حذف التصنيفات الفرعية القديمة وإضافة الجديدة
    //             ProductSubCategory::where('product_id', $product->id)->delete();
    //             ProductSubCategory::insert($sub_categories_data);
    //         }

    //         // تحديث الألوان
    //         if ($request->has('colors')) {

    //             $color_data = [];
    //             $colors = json_decode($request->colors);
    //             foreach ($colors as $color) {

    //                 $color_data[] = [
    //                     'type' => 'color',
    //                     'product_id' => $product->id,
    //                     'color' => $color,
    //                 ];
    //             }

    //             // حذف الألوان القديمة وإضافة الجديدة
    //             ProductImage::where('product_id', $product->id)->where('type', 'color')->delete();
    //             ProductImage::insert($color_data);
    //         }

    //         $product = Product::with('images')->findOrFail($request->id);

    //         DB::commit();
    //         return response()->json(
    //             [
    //                 'message' => 'Product updated successfully!',
    //                 'status' => true,
    //                 'product' => $product,
    //             ],
    //             200
    //         );
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(
    //             [
    //                 'error' => 'Failed to update product: ' . $e->getMessage(),
    //                 'status' => false,
    //             ],
    //             500
    //         );
    //     }
    // }

}
