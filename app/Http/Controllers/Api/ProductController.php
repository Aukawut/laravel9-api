<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if ($products->count()) {
            return response()->json(["status" => 200, "products" => $products], 200);
        } else {
            return response()->json(["status" => 404, "message" => "Product not found."], 404);
        }
    }
    public function addproduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "product_name" => "required||string",
            "product_desc" => "required||string",
            "product_price" => "required||integer"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->messages()
            ], 422);
        } else {

            $product = Product::create([
                "product_name" => $request->product_name,
                "product_desc" => $request->product_desc,
                "product_price" => $request->product_price
            ]);
            if ($product) {
                return response()->json([
                    "status" => 200,
                    "message" => "Product added successfully!"
                ], 200);
            } else {
                return response()->json([
                    "status" => 500,
                    "message" => "Something went Wrong!"
                ], 500);
            }
        }
    }
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                "status" => 200,
                "product" => $product
            ]);
        } else {
            return response()->json([
                "status" => 404,
                "message" => "Product not founded!"
            ], 404);
        }
    }
    public function update(Request $request, Int $id)
    {
        $validator = Validator::make($request->all(), [
            "product_name" => "required||string",
            "product_desc" => "required||string",
            "product_price" => "required||integer"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->messages()
            ], 422);
        } else {
            $student = Product::find($id);
            if ($student) {
                $student->update([
                    "product_name" => $request->product_name,
                    "product_desc" => $request->product_desc,
                    "product_price" => $request->product_price
                ]);
                return response()->json([
                    "status" => 200,
                    "message" => "Product updated successfully!"
                ], 200);
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Product not founded!"
                ], 404);
            }
        }
    }
    public function destroy($id){
        $product = Product::find($id);
        if($product){
            $product->delete();   
            return response()->json(["status" => 200, 'message' => 'Product Deleted Successfully'], 200);
        }else{
            return response()->json([
                "status" => 404,
                "message" => "Product not founded!"
            ], 404);
        }
    }
}
