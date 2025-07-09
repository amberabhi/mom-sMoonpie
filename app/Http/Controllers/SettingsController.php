<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $clsSettings;
    public function __construct(){
        $this->clsSettings = new Setting();
    }
    public function index()
    {
        $row = $this->clsSettings->first();
        return view('settings', compact('row'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'apparelmagic_endpoint' => 'required|string',
            'apparelmagic_token' => 'required|string',
            'logiwa_endpoint' => 'required|string',
            'logiwa_username' => 'required|email|string',
            'logiwa_password' => 'required|string',
            'logiwa_token' => 'required|string',
        ]);

        $this->clsSettings->find($id)->update($request->all());
        return redirect()->back()->with('success','API Settings updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
