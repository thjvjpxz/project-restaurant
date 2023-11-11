<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.tables.index', ['tables' => Table::latest()->paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.tables.form');
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
                Rule::unique('tables', 'name')
            ]
        ]);
        $table = Table::create($data);
        return redirect()->route('tables.index')->with('success', $table->name . ' added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        //
        return view('admin.tables.form', ['table' => $table]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        //
        $data = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('tables', 'name')
            ]
        ]);
        $table->update($data);
        return redirect()->route('tables.index')->with('success', 'Edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        //
        $table->delete();
        return redirect()->route('tables.index')->with('success', $table->name . ' deleted successfully!');
    }
}