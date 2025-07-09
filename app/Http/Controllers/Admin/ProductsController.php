<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\CategoriesForProduct;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $sizes = Size::get();
        $productTypes = ProductCategory::where('status', 1)->get();
        $categories = Category::where('is_active', 1)->get();

        return view('admin.products.create', compact('productTypes', 'sizes', 'categories'));
    }
 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku' => 'required|string|max:255|unique:products,sku',
            'slug' => 'required|string|max:255|unique:products,slug',
            'title' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            // 'age_group' => 'required|string|max:100',
            // 'lb' => 'required|string|max:100',
            // 'lbh' => 'required|string|max:100',
            'weight' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            // 'units_available' => 'required|integer|min:0',
            'mrp' => 'required|numeric',
            'discount' => 'nullable|numeric|min:0',
            'net_price' => 'required|numeric',
            'description' => 'nullable|string',
            'material' => 'required|string|max:255',
            'is_size_available' => 'required'
        ]);
		
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::create([
            'sku' => $request->sku,
            'brand' => 'Ganga',
            'title' => $request->title,
            'slug' => $request->slug,
            'product_type' => $request->product_type,
            'is_size_available' => $request->is_size_available,
            // 'nav_category' => $request->nav_category,
            'color' => $request->color,
            // 'age_group' => $request->age_group,
            // 'lb' => $request->lb,
            // 'lbh' => $request->lbh,
            'weight' => $request->weight,
            'quantity' => $request->quantity,
            // 'units_available' => $request->units_available,
            'mrp' => $request->mrp,
            'discount' => $request->discount,
            'net_price' => $request->net_price,
            'description' => $request->description,
            'material' => $request->material,
            'status' => isset($request->status) ? $request->status : 0,
            'is_new_collection' => isset($request->is_new_collection) ? $request->is_new_collection : 0,
            'is_trending' => isset($request->is_trending) ? $request->is_trending : 0,
            'is_in_stock' => isset($request->is_in_stock) ? $request->is_in_stock : 0
        ]);

        if(count($request->nav_category) > 0){
            foreach($request->nav_category as $categoryId){
                CategoriesForProduct::create([
                    'product_id' => $product->id,
                    'category_id' => $categoryId
                ]);
            }
        }

        // if(isset($request->product_sizes)){
        //     $this->createProductSizes($request->product_sizes, $product->id);
        // }

        $this->storeImages($request->product_images, $product->id);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function storeImages($images, $id){
        $imagePath = public_path('/images/product-image').'/'.$id;
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0775, true);
        }
		
		if(empty($images)){
			return;
		}
		
        if(count($images) > 0){
            foreach($images as $image){
                $imageName = md5(time() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
                $image->move($imagePath, $imageName);
                $storedPath = $id.'/'.$imageName;

                $imageData = [
                    'product_id' => $id,
                    'image_path' => $storedPath,
                ];

                ProductImage::create($imageData);
            }
        }
    }

    public function createProductSizes($productSizes, $id){
        if(count($productSizes) > 0){
            foreach($productSizes as $key => $value){
                $size = Size::find($value);

                $sizeData = [
                    'product_id' => $id,
                    'size_id' => $size->id,
                    'size' => $size->size
                ];
                ProductSize::create($sizeData);
            }
        }
    }

    public function edit(Product $product)
    {
        $sizes = Size::get();
        $productSizes = ProductSize::where('product_id', $product->id)->pluck('size_id')->toArray();
        $productTypes = ProductCategory::where('status', 1)->get();
        $productImages = ProductImage::where('product_id', $product->id)->get();
        $categories = Category::where('is_active', 1)->get();
        $productCategories = CategoriesForProduct::where('product_id', $product->id)->pluck('category_id')->toArray();

        return view('admin.products.edit', compact('product', 'productTypes', 'productImages', 'productSizes', 'sizes', 'categories' ,'productCategories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            // 'sku' => 'required|string|max:255|unique:products,sku',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'title' => 'required|string|max:255',
            // 'nav_category' => 'required',
            'product_type' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            // 'age_group' => 'required|string|max:100',
            // 'lb' => 'required|string|max:100',
            // 'lbh' => 'required|string|max:100',
            'weight' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            // 'units_available' => 'required|integer|min:0',
            'mrp' => 'required|numeric',
            'discount' => 'nullable|numeric|min:0',
            'net_price' => 'required|numeric',
            'description' => 'nullable|string',
            'material' => 'required|string|max:255',
            'is_size_available' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product->update([
            'sku' => $request->sku,
            'brand' => 'Ganga',
            'title' => $request->title,
            'slug' => $request->slug,
            'product_type' => $request->product_type,
            'is_size_available' => $request->is_size_available,
            // 'nav_category' => $request->nav_category,
            'color' => $request->color,
            'age_group' => $request->age_group,
            'lb' => $request->lb,
            'lbh' => $request->lbh,
            'weight' => $request->weight,
            'quantity' => $request->quantity,
            // 'units_available' => $request->units_available,
            'mrp' => $request->mrp,
            'discount' => $request->discount,
            'net_price' => $request->net_price,
            'description' => $request->description,
            'material' => $request->material,
            'status' => isset($request->status) ? $request->status : 0,
            'is_new_collection' => isset($request->is_new_collection) ? $request->is_new_collection : 0,
            'is_trending' => isset($request->is_trending) ? $request->is_trending : 0,
            'is_in_stock' => isset($request->is_in_stock) ? $request->is_in_stock : 0
        ]);

        // if(isset($request->product_sizes)){
        //     $product->productSizes()->delete();
            
        //     $this->createProductSizes($request->product_sizes, $product->id);
        // }

        if(count($request->nav_category) > 0){
            CategoriesForProduct::where('product_id', $product->id)->delete();

            foreach($request->nav_category as $categoryId){
                CategoriesForProduct::create([
                    'product_id' => $product->id,
                    'category_id' => $categoryId
                ]);
            }
        }

        if (isset($request->product_images)) {
            $this->storeImages($request->product_images, $id);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }

    public function removeImage($imageId){
        $removeImage = ProductImage::destroy($imageId);
        if($removeImage){
            return redirect()->back()->with('success', 'Image Removed.');
        }

        return redirect()->back()->with('error', 'Something Went Wrong.');
    }

    public function setDefaultImage($imageId){
        $image = ProductImage::find($imageId);
        if(!$image){
            return false;
        }

        $removeDefault = ProductImage::where('product_id', $image->product_id)->update(['is_default' => 0]);
        $setDefault = ProductImage::where('id', $imageId)->update(['is_default' => 1]);
        if($setDefault){
            return redirect()->back()->with('success', 'Image set as default.');
        }

        return redirect()->back()->with('error', 'Something Went Wrong.');
    }

    public function viewInventory($productId){
        $product = Product::find($productId);
        $sizes = Size::orderByDesc('id')->get();
		
		// Assuming $product->productSizes contains existing sizes
        $existingSizeIds = $product->productSizes->pluck('size_id')->toArray();

        // Filter sizes to exclude already existing ones
        $sizes = $sizes->reject(function ($size) use ($existingSizeIds) {
            return in_array($size->id, $existingSizeIds);
        });

        return view('admin.products.inventory', compact('product', 'sizes'));
    }

    public function storeInventory(Request $request){
        $productId = $request->product_id;

        if(isset($request->inventoryItems) && count($request->inventoryItems) > 0){
            foreach($request->inventoryItems as $sizeId => $data){
                $productSize = ProductSize::where('product_id', $productId)->where('size_id', $sizeId)->first();
                if($productSize){
                    $invData = [
                        'size' => $data['size'],
                        'stock' => $data['stock'],
                        'status' => $data['status']
                    ];
                    $productSize->update($invData);

                }else{
                    $invData = [
                        'product_id' => $productId,
                        'size' => $data['size'],
                        'size_id' => $sizeId,
                        'stock' => $data['stock'],
                        'status' => $data['status']
                    ];
                    ProductSize::create($invData);
                }
            }
        }

        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }   

}
