<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannersController extends Controller
{
    public function index(){
        $banners = Banner::orderByDesc('id')->paginate(10);

        return view('admin.banners.index', compact('banners'));
    }

    public function create(){
        return view('admin.banners.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255', 
            // 'description' => 'required|string', 
            'cta_text' => 'required|string|max:255', 
            'cta_url' => 'required',
            'image_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg', 
            'image_2' => 'required|image|mimes:jpeg,png,jpg,gif,svg', 
            'status' => 'required|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_url' => $request->cta_url,
            'status' => $request->status,
        ];
        $banner = Banner::create($data);

        if (isset($request->image_1)) {
            $this->storeImage($imgType = 1, $request->image_1, $banner->id);
        }

        if (isset($request->image_2)) {
            $this->storeImage($imgType = 2, $request->image_2, $banner->id);
        }

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner){
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner) {
        $request->validate([
            'title' => 'required|string|max:255', 
            // 'description' => 'required|string', 
            'cta_text' => 'required|string|max:255', 
            'cta_url' => 'required',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', 
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', 
            'status' => 'required|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_url' => $request->cta_url,
            'status' => $request->status,
        ];
        $banner->update($data);

        if (isset($request->image_1)) {
            $this->storeImage($imgType = 1, $request->image_1, $banner->id);
        }

        if (isset($request->image_2)) {
            $this->storeImage($imgType = 2, $request->image_2, $banner->id);
        }

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner) {
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }

    public function storeImage($imgType, $image, $id){
        $imagePath = public_path('/images/banner').'/'.$id;
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0775, true);
        }
		
        $imageName = md5(time() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $image->move($imagePath, $imageName);
        $storedPath = $id.'/'.$imageName;

        if($imgType == 1){
            Banner::find($id)->update(['image_1' => $storedPath]);
        }

        if($imgType == 2){
            Banner::find($id)->update(['image_2' => $storedPath]);
        }

        return true;
    }
}
