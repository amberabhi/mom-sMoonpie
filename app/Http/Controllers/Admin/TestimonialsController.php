<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialsController extends Controller
{
    public function index(){
        $testimonials = Testimonial::orderByDesc('id')->paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(){
        return view('admin.testimonials.create');
    }

    public function store(Request $request) {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'review' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'rating' => 'required|numeric',
            'status' => 'required',
        ]);

        $data = [
            'customer_name' => $request->customer_name,
            'title' => $request->title,
            'review' => $request->review,
            'rating' => $request->rating,
            'status' => $request->status,
        ];
        $testimonial = Testimonial::create($data);

        if (isset($request->image)) {
            $this->storeImage($request->image, $testimonial->id);
        }

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function storeImage($image, $id){
        $imagePath = public_path('/images/testimonial').'/'.$id;
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0775, true);
        }
		
        $imageName = md5(time() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $image->move($imagePath, $imageName);
        $storedPath = $id.'/'.$imageName;

        return Testimonial::find($id)->update([
            'image' => $storedPath,
        ]);
    }

    public function edit(Testimonial $testimonial){
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial) {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'review' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'rating' => 'required|numeric',
            'status' => 'required',
        ]);

        $data = [
            'customer_name' => $request->customer_name,
            'title' => $request->title,
            'review' => $request->review,
            'rating' => $request->rating,
            'status' => $request->status,
        ];
        $testimonial->update($data);

        if (isset($request->image)) {
            $this->storeImage($request->image, $testimonial->id);
        }

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial) {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
