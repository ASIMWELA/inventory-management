<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\ProductCategory;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api')->except(['getAllProducts']);
        $this->user = $this->guard()->user();
    }

    public function getAllProducts(){

        $products = Product::all();

        return response()->json([
            "products"=>$products
        ]);
    }
    public function addProduct($categoryName, Request $product): \Illuminate\Http\JsonResponse
    {

        $findCategory = ProductCategory::where('name', '=', $categoryName)->first();

        //check if the product is there


        if(! $findCategory){
            return response()->json([
                "status"=>'fail',
                "success"=>0,
                "message"=>"No category found with name " .$categoryName
           ], 404);
        }


      //  validate the product
        $product->validate([
           'name'=>'required',
            'quantity'=>'required',
            'threshold'=>'required',
            'available'=>'required',
            'price_per_unit'=>'required',
            'description'=>'required'
        ]);

        $newProduct = new Product;

        $newProduct->name = $product->name;
        $newProduct->description = $product->description;
        $newProduct->quantity = $product->quantity;
        $newProduct->available = $product->available;
        $newProduct->price_per_unit = $product->price_per_unit;
        $newProduct->threshold = $product->threshold;
        $newProduct->category_id = $findCategory->id;


       // $findCategory->product()-> = $newProduct;
        //$findCategory->save();
        $newProduct->save();

//
//


        return response()->json([
           "status" => "ok",
            "message"=>"Product added  successfully"
        ]);

    }

    public function editProduct($id){

    }

    private function guard()
    {
        return Auth::guard();
    }
}
