<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index(){
        $settings = Setting::first();

        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request){
        $request->validate([
            'tax_below_1k' => 'required|numeric',
            'tax_above_1k' => 'required|numeric',
            'shipping_charge' => 'required|numeric',
        ]);

        $data = [
            'tax_below_1k' => $request->tax_below_1k,
            'tax_above_1k' => $request->tax_above_1k,
            'shipping_charge' => $request->shipping_charge,
        ];
        Setting::first()->update($data);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
