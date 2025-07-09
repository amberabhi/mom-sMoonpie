<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryRequest;
use App\Repositories\Admin\Eloquents\ProductCategoryRepository;

class ProductCategoryController extends Controller
{
    protected $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function index(){
        $categories = ProductCategory::paginate(10);

        return view('admin.product-categories.index', compact('categories'));
    }

    public function create(){
        return view('admin.product-categories.create');
    }

    public function store(ProductCategoryRequest $request){
        $storeRecord = $this->productCategoryRepository->storeRecord($request);
        if($storeRecord){
            return redirect()->route('admin.product-categories.index')->with('success', 'Product Type Inserted.');
        }

        return redirect()->route('admin.product-categories.index')->with('error', 'Something Went Wrong.');
    }

    public function edit(ProductCategory $productCategory){

        return view('admin.product-categories.edit', compact('productCategory'));
    } 

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory){
        $updateRecord = $this->productCategoryRepository->updateRecord($request, $productCategory->id);
        if($updateRecord){
            return redirect()->route('admin.product-categories.index')->with('success', 'Product Type Updated.');
        }

        return redirect()->route('admin.product-categories.index')->with('error', 'Something Went Wrong.');
    } 

    public function destroy(ProductCategory $productCategory){
        // if ($productCategory->products()->count() > 0) {
        //     return redirect()->route('admin.product-categories.index')->with('error', 'Cannot delete category with associated products.');
        // }
        
        $deleteRecord = $this->productCategoryRepository->deleteRecord($productCategory->id);
        if($deleteRecord){
            return redirect()->route('admin.product-categories.index')->with('success', 'Product Type Deleted.');
        }

        return redirect()->route('admin.product-categories.index')->with('error', 'Something Went Wrong.');
    } 
}
