<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\CategoryController;


Route::get('/dcsc', function() {
    $exitCode = Artisan::call('optimize:clear');
    return 'what you want';
});


Route::get('/', function () {
    return view('dashboard.dashboard');
})->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth']);



Route::group(['middleware'=>['auth'],'as'=>'dashboard.'], function(){


    // students
    Route::get('/students',                [StudentController::class, 'students'])->name('students');
    Route::get('/get_all_students',        [StudentController::class, 'get_all_students'])->name('get_all_students');
    Route::post('/store_students',         [StudentController::class, 'store_students'])->name('store_students');
    Route::post('/update_students',        [StudentController::class, 'update_students'])->name('update_students');
    Route::post('/destroy_students',       [StudentController::class, 'destroy_students'])->name('destroy_students');
    Route::post('/is_view_students',       [StudentController::class, 'is_view_students'])->name('is_view_students');


    //admins
    Route::get('/admins',               [AdminController::class, 'admins'])->name('admins')->middleware(['permission:فريق النظام']);
    Route::get('/get_all_admins',       [AdminController::class, 'get_all_admins'])->name('get_all_admins')->middleware(['permission:فريق النظام']);
    Route::post('/store_admins',        [AdminController::class, 'store_admins'])->name('store_admins')->middleware(['permission:فريق النظام']);
    Route::post('/update_admins',       [AdminController::class, 'update_admins'])->name('update_admins')->middleware(['permission:فريق النظام']);
    Route::post('/destroy_admins',      [AdminController::class, 'destroy_admins'])->name('destroy_admins')->middleware(['permission:فريق النظام']);

    // categories
    Route::get('/categories',                [CategoryController::class, 'categories'])->name('categories');
    Route::get('/get_all_categories',        [CategoryController::class, 'get_all_categories'])->name('get_all_categories');
    Route::post('/store_categories',         [CategoryController::class, 'store_categories'])->name('store_categories');
    Route::post('/update_categories',        [CategoryController::class, 'update_categories'])->name('update_categories');
    Route::post('/destroy_categories',       [CategoryController::class, 'destroy_categories'])->name('destroy_categories');
    Route::post('/is_view_categories',       [CategoryController::class, 'is_view_categories'])->name('is_view_categories');


    Route::resource('roles',        RoleController::class)->middleware(['permission:الصلاحيات']);
    Route::post('/update_rolee',    [RoleController::class,       'update_rolee'])->name('update_rolee')->middleware(['permission:الصلاحيات']);
    Route::get('/get_all_role',     [PermissionController::class, 'get_all_role'])->name('get_all_role')->middleware(['permission:الصلاحيات']);

    Route::get('/myprofile',             [AdminController::class,'myprofile'])->name('myprofile');
    Route::post('/myprofile_update',     [AdminController::class,'myprofile_update'])->name('myprofile_update');

});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
