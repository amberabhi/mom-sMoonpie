<?php

namespace App\Http\Controllers\Front;

use App\Models\Banner;
use App\Models\Product;
use App\Models\MarqueeItem;
use App\Models\ProductSize;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoriesForProduct;

class IndexController extends Controller
{
    public function index(){
        $trendingProducts = Product::with(['productImages' => function($query) {
                                $query->orderByDesc('is_default')
                                    ->orderBy('id');
                            }])
                            ->where('is_trending', 1)
                            ->where('status', 1)
                            ->get();

        $newCollections = Product::with(['productImages' => function($query) {
                                $query->orderByDesc('is_default')
                                    ->orderBy('id');
                            }])
                            ->where('is_new_collection', 1)
                            ->where('status', 1)
                            ->get();

        $marqueeItems = MarqueeItem::where('status', 1)->get();

        $testimonials = Testimonial::where('status', 1)->get();

        $banners = Banner::where('status', 1)->get();

        return view('front.index', compact('trendingProducts', 'newCollections', 'marqueeItems', 'testimonials', 'banners'));
    }

    public function productList(Request $request) {
        $query = Product::with(['productImages' => function($query) {
            $query->orderByDesc('is_default')
                ->orderBy('id');
        }])->whereNotNull('id')
			->where('status', 1);

        $category = $request->query('category');
        $categoryId = $request->query('catid');
        if ($categoryId) {
            // $query->where('nav_category', $category);
            $productIds = CategoriesForProduct::where('category_id', $categoryId)->pluck('product_id')->toArray();
            
            $query->whereIn('id', $productIds);
        }

        $searchText = $request->query('search');
        if ($searchText) {
            $query->where('title', 'like' , '%'.$searchText."%");
        }
        
        $products = $query->paginate(12)->withQueryString();

        return view('front.product-list', compact('products', 'category', 'searchText'));
    }

    public function productDetails($product) {
        $product = Product::with(['productImages' => function($query) {
                                $query->orderByDesc('is_default')
                                    ->orderBy('id');
                            },'productType'])->where('slug', $product)->where('status', 1)->first();
        if(empty($product)){
            abort(404);
        }

        $productSizes = $product->productSizes->where('status', 1);

        return view('front.product-details', compact('product', 'productSizes'));
    }

    public function productInventory(Request $request){
        $inventory = 0;
        
        $productSize = ProductSize::find($request->invId);
        if($productSize){
            $inventory = $productSize->stock;
        }

        return response()->json(['inventory' => $inventory]);
    }
}
