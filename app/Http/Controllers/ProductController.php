<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $product = Product::orderBy('created_at', 'desc')->get();
        return response()->json($product);
    }

    public function activeProducts()
    {
        $product = Product::where('status', 'active')->orderBy('created_at', 'desc')->get();
        return response()->json($product);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
                'info' => 'required',
                'description' => 'required',

            ]);
            if ($validator->fails()) {
                return response()->json(['errorLists' => $validator->errors()], 200);
            }
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->info = $request->info;
            $product->description = $request->description;
            $product->status = $request->status === 'active' || $request->status === true || $request->status === 1 ? 'active' : 'inactive';
            $product->save();
            return response()->json($product, 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 403);
        }

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'info' => 'required',
            'description' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['errorLists' => $validator->errors()], 200);
        }
        $product = Product::find($id);
        if ($product) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->info = $request->info;
            $product->description = $request->description;
            $product->status = $request->status === 'active' || $request->status === true || $request->status === 1 ? 'active' : 'inactive';
            $product->save();
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->status = 'inactive';
            $product->save();
            return response()->json(['message' => 'Product deactivated']);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
