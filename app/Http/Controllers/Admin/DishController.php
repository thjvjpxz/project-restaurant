<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.dishes.index', ['dishes' => Dish::latest()->paginate(3)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.dishes.form', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('dishes', 'name')
            ],
            'category_id' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:1',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $data['image_url'] =$request->hasFile('image_url') ? $request->file('image_url')
            ->store('images', 'public') : null;
        $dish = Dish::create($data);
        return redirect()->route('dishes.index')->with('success', $dish->name . ' added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        //
        return view('admin.dishes.form', compact('dish'), ['categories' => Category::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dish $dish)
    {
        //
        $dish_id_curr = $dish->id;
        $data = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('dishes', 'name')->ignore($dish_id_curr)
            ],
            'category_id' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:1',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $data['image_url'] =$request->hasFile('image_url') ? $request->file('image_url')
            ->store('images', 'public') : $dish->image_url;

        $dish->update($data);
        return redirect()->route('dishes.index')->with('success', $dish->name . ' added successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        //
        $dish->delete();
        return redirect()->route('dishes.index')->with('success', $dish->name . ' deleted successfully!');
    }
}
