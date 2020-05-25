<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
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
        return response()->json($data);
    }

    public function store(Request $request)
    {
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
            ]);
        }
    }

    public function update(Request $request, Category $category)
    {
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
            ]);
        }
    }

    public function destroy(Category $category)
    {
        if($category->delete()) {
            return response()->json([
                'message' => 'category is deleted successfully'
            ]);
        }
    }
}
