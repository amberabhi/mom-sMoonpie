<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $dates = [ 'deleted_at' ];

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function productSizes(): HasMany
    {
        return $this->hasMany(ProductSize::class, 'product_id', 'id');
    }

    public function productType(){
        return $this->belongsTo(ProductCategory::class,'product_type');
    }

    public function isInCustomerWishlist()
    {
        return auth()->guard('customer')->user()->wishlist()->where('product_id', $this->id)->exists();
    }
}
