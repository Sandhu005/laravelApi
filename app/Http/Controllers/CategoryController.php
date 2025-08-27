<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        if($category->isEmpty()){
            return response()->json([
                "success" => false,
                "status" => 400,
                "message" => "Category not found!",
            ]);

        }else{
             return response()->json([
                "success" => true,
                "status" => 200,
                "message" => "Category Added Successfully!",
                "data" => $category,

            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateCategory = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $existingCategory = Category::where('name', $validateCategory['name'])->first();

        if (!$existingCategory) {
            $category = new Category();
            $category->name = $validateCategory['name'];
            $category->description = $validateCategory['description'];

            $category->save();

            return response()->json([
                "success" => true,
                "status" => 201,
                "message" => "Category Added Successfully!",
                "data" => $category,

            ]);
        }else{
            return response()->json([
                "success" => false,
                "status" => 400,
                "message" => "Category Already Exists!",
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        
        if (!$category) {
            return response()->json([
                "success" => false,
                "status" => 404,
                "message" => "Category not found!"
            ]);
        } else {
            return response()->json([
                "success" => true,
                "status" => 200,
                "message" => "Category Loaded",
                "data" => $category
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
