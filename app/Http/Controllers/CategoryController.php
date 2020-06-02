<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() {
        $categories = Category::all();
        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->id,
                'user' => $category->user->name,
                'name' => $category->name
            ];
        }
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'you have not permission to create category'
            ], 403);
        }

        $this->validate($request, [
            'name' => 'required|min:3'
        ]);

        $category = new Category();
        $category->user_id = auth()->user()->id;
        $category->name = $request->name;

        if($category->save()) {
            return response()->json([
                'message' => 'category is created successfully',
                'category' => [
                    'id' => $category->id,
                    'user' => $category->user->name,
                    'name' => $category->name
                ]
            ], 201);
        }
    }

    public function update(Request $request, Category $category)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'you have not permission to update category'
            ], 403);
        }

        $this->validate($request, [
            'name' => 'required|min:3'
        ]);

        $category->name = $request->name;

        if($category->save()) {
            return response()->json([
                'message' => 'category is updated successfully',
                'category' => [
                    'id' => $category->id,
                    'user' => $category->user->name,
                    'name' => $category->name
                ]
            ], 202);
        }
    }

    public function destroy(Category $category)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'you have not permission to delete category'
            ], 403);
        }

        if($category->delete()) {
            return response()->json([
                'message' => 'category is deleted successfully'
            ], 200);
        }
    }
}
