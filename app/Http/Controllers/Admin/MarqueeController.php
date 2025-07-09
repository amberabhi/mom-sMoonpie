<?php

namespace App\Http\Controllers\Admin;

use App\Models\MarqueeItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarqueeController extends Controller
{
    public function index(){
        $marqueeItems = MarqueeItem::orderByDesc('id')->paginate(10);

        return view('admin.marquee-items.index', compact('marqueeItems'));
    }

    public function create(){
        return view('admin.marquee-items.create');
    }

    public function store(Request $request) {
        $request->validate([
            'content' => 'required',
            'status' => 'required',
        ]);

        MarqueeItem::create($request->all());

        return redirect()->route('admin.marquee-items.index')->with('success', 'Item created successfully.');
    }

    public function edit(MarqueeItem $marqueeItem){

        return view('admin.marquee-items.edit', compact('marqueeItem'));
    }

    public function update(Request $request, MarqueeItem $marqueeItem) {
        $request->validate([
            'content' => 'required',
            'status' => 'required',
        ]);

        $marqueeItem->update($request->all());

        return redirect()->route('admin.marquee-items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(MarqueeItem $marqueeItem) {
        $marqueeItem->delete();

        return redirect()->route('admin.marquee-items.index')->with('success', 'Item deleted successfully.');
    }
}
