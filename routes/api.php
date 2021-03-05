<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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


//product categories routes for admin
Route::prefix('product-categories')->middleware(['auth:api', 'can:accessAdmin'])->group(function (){
    Route::post('/', [ProductCategoryController::class, 'addProductCategory']);
    Route::put('/{id}', [ProductCategoryController::class, 'editProductCategory']);
    Route::delete('/{id}', [ProductCategoryController::class, 'deleteProductCategory']);
});

Route::prefix('orders')->group(function(){
    Route::post('/{productId}', [OrderController::class, 'addToCart']);
    Route::put('/checkout', [OrderController::class, 'checkoutOrder']);
    Route::put('/', [OrderController::class, 'resetCartPrice']);
    Route::get('/complete/{userName}', [OrderController::class, 'getCompletedOrderByUserName']);
    Route::get('/complete', [OrderController::class, 'getCompletedOrders']);
    Route::put('/{orderId}', [OrderController::class, 'confirmOrder'])->middleware(['auth:api', 'can:accessAdmin']);
    Route::get('/', [OrderController::class, 'getOrders'])->middleware(['auth:api', 'can:accessAdmin']);

});
//open routes
Route::prefix('product-categories')->group(function (){
    Route::get('/', [ProductCategoryController::class, 'getAllProductCategories']);
    Route::get('/{id}', [ProductCategoryController::class, 'getCategory']);
});


//protected products
Route::prefix('products')->middleware(['auth:api', 'can:accessAdmin'])->group(function(){
    Route::get('/',[ProductController::class, 'getAllProducts'] );
    Route::post('/{categoryName}', [ProductController::class, 'addProduct']);
    Route::put('/{id}', [ProductController::class, 'editProduct']);
    Route::delete('/{id}', [ProductController::class, 'deleteProduct']);
});

//open routes
Route::prefix('products')->group(function(){
    Route::get('/',[ProductController::class, 'getAllProducts'] );
    Route::get('/{id}',[ProductController::class, 'getProduct'] );

});
//user routes
Route::prefix('users')->group(function(){
    Route::post('/auth', [UserController::class, 'login']);
    Route::post('/', [UserController::class, 'registerUser']);
    Route::get('/', [UserController::class, 'getAllUsers']);
});

//Rigister admin
Route::post('/admin/register', [UserController::class, 'registerAdmin'])->middleware(['auth:api', 'can:accessAdmin']);

