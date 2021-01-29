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
        $this->middleware('auth:api')->except(['getAllProducts', 'getProduct']);
        $this->user = $this->guard()->user();
    }

    public function getAllProducts(){

        $products = Product::all();

        return response()->json([
            "products"=>$products
        ]);
    }

    public function getProduct($id){
        $product = Product::find($id);

        if(is_null($product)){
            return response()->json([
                "status"=>"fail",
                "success"=>0,
                "message"=>"No product found with id " . $id
            ], 404);
        }
        return response()->json([
            "data"=>$product
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

    public function editProduct(Request $product, $id){

        $oldProduct = Product::find($id);

        if(is_null($oldProduct)){
            return response()->json([
                "status"=>"fail",
                "success"=>0,
                "message"=>"No product found with id " . $id
            ], 404);
        }

        $product->validate([
            'name'=>'required',
            'quantity'=>'required',
            'threshold'=>'required',
            'available'=>'required',
            'price_per_unit'=>'required',
            'description'=>'required'
        ]);

        $oldProduct->name = $product->name;
        $oldProduct->description = $product->description;
        $oldProduct->quantity = $product->quantity;
        $oldProduct->available = $product->available;
        $oldProduct->price_per_unit = $product->price_per_unit;
        $oldProduct->threshold = $product->threshold;

        $oldProduct->save();

        return response()->json([
            "status" => "ok",
            "message"=>"Product edited  successfully"
        ], 200);


    }

    public function deleteProduct($id){
        $product = Product::find($id);

        if(is_null($product)){
            return response()->json([
                "status"=>"fail",
                "success"=>0,
                "message"=>"No product found with id " . $id
            ], 404);
        }

        $product->delete();

        return response()->json([
            "status" => "ok",
            "message"=>"Product deleted  successfully"
        ], 200);



    }

    private function guard()
    {
        return Auth::guard();
    }
}
