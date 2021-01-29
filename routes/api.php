<?php

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//product categories routes 
Route::prefix('product-categories')->middleware(['auth:api', 'can:accessAdmin'])->group(function (){
    Route::post('/', [ProductCategoryController::class, 'addProductCategory']);
    Route::get('/', [ProductCategoryController::class, 'getAllProductCategories']);
    Route::get('/{id}', [ProductCategoryController::class, 'getCategory']);
    Route::put('/{id}', [ProductCategoryController::class, 'editProductCategory']);
    Route::delete('/{id}', [ProductCategoryController::class, 'deleteProductCategory']);
});

//products category
Route::prefix('products')->group(function(){
    Route::get('/',[ProductController::class, 'getAllProducts'] );
    Route::post('/{categoryName}', [ProductController::class, 'addProduct']);
});

//user routes
Route::prefix('users')->group(function(){
    Route::post('/auth', [\App\Http\Controllers\UserController::class, 'login']);
    Route::post('/', [\App\Http\Controllers\UserController::class, 'registerUser']);
    Route::get('/', [\App\Http\Controllers\UserController::class, 'getAllUsers']);
});

//Route::prefix('products')->middleware(['auth:api', 'can:accessAdmin'])->group(function () {
//    Route::get('/',[ProductController::class, 'getAllProducts'] );
//    Route::post('/{categoryName}', [ProductController::class, 'addProduct']);
//    });
