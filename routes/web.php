<?php

use App\Http\Controllers\Admin\ProductImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin Routes
Route::get('admin-panel/dashboard',[DashboardController::class , 'index'])->name('dashboard');

Route::prefix('admin-panel/managment')->name('admin.')->group(function ()
{
    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);

    // Edit Product Images
    Route::get('/products/{product}/images-edit' , [ProductImageController::class , 'edit'])->name('products.images.edit');
    Route::delete('/products/{product}/images-destroy' , [ProductImageController::class , 'destroy'])->name('product.images.destroy');
    Route::put('/products/{product}/images-set-primary' , [ProductImageController::class , 'setPrimary'])->name('product.images.set_primary');
    Route::post('/products/{product}/images-add' , [ProductImageController::class , 'add'])->name('products.images.add');

    // Edit Product Category
    Route::get('/products/{product}/category-edit' , [ProductController::class , 'editCategory'])->name('products.category.edit');
    Route::put('/products/{product}/category-update' , [ProductController::class , 'updateCategory'])->name('products.category.update');

});
