<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::view('form', 'form');

Route::get('test/{id?}/{slug?}', function ($id = null, $slug = null) {
    return 'Phuong thuc GET voi ID = ' . $id . ' va slug = ' . $slug;
});

Route::prefix('categories')->group(function () {
    // Danh sách chuyên mục
    Route::get('/', [CategoriesController::class, 'index'])->name('categories.list');

    // Lấy chi tiết một chuyên mục (Áp dụng show form để sửa chuyên mục)
    Route::get('edit/{id}', [CategoriesController::class, 'getCategory'])->name('categories.edit');;

    // Lấy chi tiết một chuyên mục (Áp dụng show form để sửa chuyên mục)
    Route::put('add', [CategoriesController::class, 'updateCategory'])->name('categories.update');;
});

Route::middleware('auth.admin')->prefix('admin')->group(function () {
    Route::resource('products', ProductsController::class);
});
