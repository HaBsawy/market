<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $products = Product::all();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->id,
                'user' => $product->user->name,
                'category' => $product->category->name,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'brand' => $product->brand,
                'min_allowed_stock' => $product->min_allowed_stock,
                'description' => $product->description,
                'image' => $product->image,
            ];
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        if(auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'you have not permission to create product'
            ], 403);
        }

        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:3|max:30',
            'price' => 'required|min:0|max:9999.99',
            'stock' => 'required|min:0|max:1000',
            'brand' => 'required|min:3|max:20',
            'min_allowed_stock' => 'required|min:0|max:100',
            'description' => 'required|min:10|max:500',
        ]);

        if($request->image !== null) {
            $this->validate($request, [
                'image' => 'image|max:1024|mimes:jpeg,jpg,png'
            ]);
            $image = $request->image;
            $image_name = $image->getClientOriginalName();
            $image_size = round($image->getSize() / 1024);
            $image_ex = $image->getClientOriginalExtension();
            $full_name = time() . '_' . $image_name;
        }

        $product = new Product();
        $product->user_id = auth()->user()->id;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->brand = $request->brand;
        $product->min_allowed_stock = $request->min_allowed_stock;
        $product->description = $request->description;
        if($request->image !== null) {
            $product->image = $full_name;
            $image->move('uploads', $full_name);
        }

        if($product->save()) {
            return response()->json([
                'message' => 'product is created successfully',
                'product' => [
                    'id' => $product->id,
                    'user' => $product->user->name,
                    'category' => $product->category->name,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'brand' => $product->brand,
                    'min_allowed_stock' => $product->min_allowed_stock,
                    'description' => $product->description,
                    'image' => $product->image,
                ]
            ], 201);
        }
    }

    public function update(Request $request, Product $product)
    {
        if(auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'you have not permission to update product'
            ], 403);
        }

        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:3|max:30',
            'price' => 'required|min:0|max:9999.99',
            'stock' => 'required|min:0|max:1000',
            'brand' => 'required|min:3|max:20',
            'min_allowed_stock' => 'required|min:0|max:100',
            'description' => 'required|min:10|max:500',
        ]);

        if($request->image !== 'null') {
            $this->validate($request, [
                'image' => 'image|max:1024|mimes:jpeg,jpg,png'
            ]);
            $image = $request->image;
            $image_name = $image->getClientOriginalName();
            $image_size = round($image->getSize() / 1024);
            $image_ex = $image->getClientOriginalExtension();
            $full_name = time() . '_' . $image_name;
        }

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->brand = $request->brand;
        $product->min_allowed_stock = $request->min_allowed_stock;
        $product->description = $request->description;
        if($request->image !== 'null') {
            $oldImage = $product->image;
            $product->image = $full_name;
            $image->move('uploads', $full_name);
            if (is_file(public_path('uploads\\' . $oldImage))) {
                unlink(public_path('uploads\\' . $oldImage));
            }
        }

        if($product->save()) {
            return response()->json([
                'message' => 'product is created successfully',
                'product' => [
                    'id' => $product->id,
                    'user' => $product->user->name,
                    'category' => $product->category->name,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'brand' => $product->brand,
                    'min_allowed_stock' => $product->min_allowed_stock,
                    'description' => $product->description,
                    'image' => $product->image,
                ]
            ], 201);
        }
    }

    public function destroy(Product $product)
    {
        if(auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'you have not permission to delete product'
            ], 403);
        }

        $image = $product->image;
        if($product->delete()) {
            if ($image != null) {
                if (is_file(public_path('uploads\\' . $image))) {
                    unlink(public_path('uploads\\' . $image));
                }
            }

            return response()->json([
                'message' => 'product is deleted successfully'
            ], 200);
        }
    }
}
