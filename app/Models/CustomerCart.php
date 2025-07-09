<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerCart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'customer_carts';

    /**
     * Get the product associated with the CustomerCart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * Get the productSize associated with the CustomerCart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function productSize(): HasOne
    {
        return $this->hasOne(ProductSize::class, 'id', 'product_size_id');
    }

    /**
     * Get the customer associated with the CustomerCart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
