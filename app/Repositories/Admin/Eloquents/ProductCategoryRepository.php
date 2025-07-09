<?php

namespace App\Repositories\Admin\Eloquents;

use App\Models\Product;
use App\Models\ProductCategory;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Vite;
use App\Repositories\Admin\Interfaces\ProductCategoryRepositoryInterface;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    public function __construct(){
        $this->modelName = new ProductCategory();
    }

    public function getAllRecords(){
        return $this->modelName::orderByDesc('id')->get();
    }

    public function getActiveRecords(){
        return $this->modelName::where('status', 1)->orderBy('title')->get();
    }

    public function getDatatable(){
        $records = $this->getAllRecords();
        
        return DataTables::of($records)

        ->editColumn('image_path',function($record){
            return productCategoryImagesBasepath().'/'.$record->image_path;
        })

        ->addColumn('action',function($record){
            return '<ul class="table-controls">
                <li><a href="'.route('admin.product-categories.edit', $record->id).'" class="bs-tooltip" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Edit" data-original-title="Edit"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-edit-2 text-primary p-1 br-8 mb-1">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                            </path>
                        </svg></a></li>
                <li><a href="javascript:void(0);" onclick="removeRecord('.$record->id.')" class="bs-tooltip" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Delete" data-original-title="Delete"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-trash text-danger p-1 br-8 mb-1">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path
                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                            </path>
                        </svg></a></li>
            </ul>';
        })
        
        ->rawColumns(['action', 'image_path'])
        ->make(true);
    }

    public function storeRecord($request){
        $data = $request->merge(['created_by' => auth()->user()->id])->only(['title', 'status', 'description', 'created_by']);
        
        $record = $this->modelName::create($data);
        if(!$record){
            return false;
        }

        $this->storeImage($request->image, $record->id);
        
        return $record;
    }

    public function updateRecord($request, $id){
        $data = $request->merge(['updated_by' => auth()->user()->id])->only(['title', 'status', 'description', 'updated_by']);

        $update = $this->modelName::find($id)->update($data);
        if(!$update){
            return false;
        }

        if ($request->hasFile('image')) {
            $this->storeImage($request->image, $id);
        }

        return $update;
    }

    public function deleteRecord($id){
        $delete = $this->modelName::destroy($id);
        if(!$delete){
            return false;
        }

        return true;
    }

    public function storeImage($image, $id){
        $imagePath = public_path('/images/product-category').'/'.$id;
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0775, true);
        }
        $imageName = md5(time() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $image->move($imagePath, $imageName);

        $storedPath = $id.'/'.$imageName;

        return $this->modelName::where('id', $id)->update(['image_path' => $storedPath]);
    }
}
