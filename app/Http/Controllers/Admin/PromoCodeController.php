<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromoCodeController extends Controller
{
    public function index(){
        $promocodes = PromoCode::orderByDesc('id')->paginate(10);

        return view('admin.promocodes.index', compact('promocodes'));
    }

    public function create(){
        return view('admin.promocodes.create');
    }

    public function store(Request $request) {
        $request->validate([
            'code' => 'required|unique:promocodes',
            'discount' => 'required|numeric',
            'type' => 'required|in:percentage,fixed',
            'expiry_date' => 'required|date',
            'is_active' => 'required|boolean',
        ]);

        PromoCode::create($request->all());

        return redirect()->route('admin.promocodes.index')->with('success', 'Promocode created successfully.');
    }

    public function edit(PromoCode $promocode){
        return view('admin.promocodes.edit', compact('promocode'));
    }

    public function update(Request $request, PromoCode $promocode) {
        $request->validate([
            'code' => 'required|unique:promocodes,code,' . $promocode->id,
            'discount' => 'required|numeric',
            'type' => 'required|in:percentage,fixed',
            'expiry_date' => 'required|date',
            'is_active' => 'required|boolean',
        ]);

        $promocode->update($request->all());

        return redirect()->route('admin.promocodes.index')->with('success', 'Promocode updated successfully.');
    }

    public function destroy(PromoCode $promocode) {
        $promocode->delete();

        return redirect()->route('admin.promocodes.index')->with('success', 'Promocode deleted successfully.');
    }

}
