<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Doctrine\Inflector\Rules\French\Rules;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.categories.index', ['categories' => Category::latest()->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name' => [
                'max:255',
                'required',
                Rule::unique('categories', 'name')
            ]
        ]);
        $category = Category::create($data);
        return redirect()->route('categories.index')->with('success', $category->name . ' created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $data = $request->validate([
            'name' => [
                'max:255',
                'required',
                Rule::unique('categories', 'name')->ignore($category->name)
            ]
        ]);
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category_name = $category->name;
        $category->delete();
        return redirect()->route('categories.index')->with('success', $category_name . ' successfully');
    }
}