<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductCategoryController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    //get product category
    public function getAllProductCategories(){

        $productCategories =  ProductCategory::all();

        return response()->json(["categories"=>$productCategories], 200);
    }

    public function getCategory($id){

        $productCategory = ProductCategory::find($id);
        $products = Product::where('category_id', '=', $id)->get();

       // $products = $productCategory->products;

        $productCategory->products = $products;


        return response()->json([
            $productCategory,

        ], 200);

    }

    //add product category
    public function addProductCategory(Request $productCategory){

        $productCategory->validate([
           'name'=>'required|min:3|max:90',
            'description'=>'required'
        ]);

//        $rules =[
//            'name'=>'required|min:3|max:90',
//            'description'=>'required'
//        ];
//
//
//        $validate = Validator::make($productCategory->all(), $rules);
//
//        Log::info($validate->errors());

        $newProduct = new ProductCategory;

        $newProduct->name = $productCategory->name;
        $newProduct->description=$productCategory->description;

        $newProduct->save();

        return response()->json([
            "status"=>"ok",
            "success"=>1,
            'message'=>'Product Category added successfully'
        ], 201);

    }

    public function editProductCategory(Request $newCategory, $id){

        $productCategory = ProductCategory::find($id);

        if(is_null($productCategory)){
            return response()->json([
                "status"=>"fail",
                "success"=>0,
                "message"=>"No category found with id " . $id
            ], 404);
        }

        $productCategory->name=$newCategory->name;
        $productCategory->description=$newCategory->description;

        $productCategory->save();

        return response()->json([
            "status"=>"ok",
            "success"=>1,
            "message"=>"product Category updated successfully"
        ], 200);

    }

    public  function deleteProductCategory($id){
        $productCategory = ProductCategory::find($id);

        if(is_null($productCategory)){
            return response()->json([
                "status"=>"fail",
                "success"=>0,
                "message"=>"No category found with id " . $id
            ], 404);
        }

        $productCategory->delete();

        return response()->json([
            "status"=>"ok",
            "success"=>1,
            "message"=>"Product deletion successful"
        ], 200);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
