<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SizeController extends Controller
{
    public function index(){
        $sizes = Size::orderByDesc('id')->paginate(10);

        return view('admin.sizes.index', compact('sizes'));
    }

    public function create(){
        return view('admin.sizes.create');
    }

    public function store(Request $request) {
        $request->validate([
            'size' => 'required',
        ]);

        Size::create($request->all());

        return redirect()->route('admin.sizes.index')->with('success', 'Size created successfully.');
    }

    public function edit(Size $size){
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size) {
        $request->validate([
            'size' => 'required',
        ]);

        $size->update($request->all());

        return redirect()->route('admin.sizes.index')->with('success', 'Size updated successfully.');
    }

    public function destroy(Size $size) {
        $size->delete();

        return redirect()->route('admin.sizes.index')->with('success', 'Size deleted successfully.');
    }
}
