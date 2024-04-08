<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Models\SubCategory;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
        Route::post('/authorization', [AdminController::class, 'authorization'])->name('admin.authorization');
    });

    Route::group(['middleware' => 'admin.auth'], function () {

        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        //category listing route
        Route::get('/category', [CategoryController::class, 'index'])->name('show.category');
        //create category page
        Route::get('/create-category', [CategoryController::class, 'create'])->name('create.category');
        Route::post('/store-category', [CategoryController::class, 'store'])->name('store.category');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('edit.category');
        Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('update.category');
        Route::delete('delete-category/{id}', [CategoryController::class, 'destroy'])->name('delete.category');

        //SubCategory Route
        Route::get('sub-category', [SubCategoryController::class, 'index'])->name('show.subcategory');
        Route::get('sub-category/category', [SubCategoryController::class, 'create'])->name('create.subcategory');
        Route::post('sub-category/store', [SubCategoryController::class, 'store'])->name('store.subcategory');
        Route::get('sub-category/{subCategory}/edit', [SubCategoryController::class, 'edit'])->name('edit.subcategory');
        Route::post('sub-category/{subCategory}/update', [SubCategoryController::class, 'update'])->name('update.subcategory');
        Route::delete('delete-subcategory/{id}', [SubCategoryController::class, 'destroy'])->name('delete.category');

        //Brand Route
        Route::get('brand/create', [BrandController::class, 'create'])->name('create.brand');
    });
});
