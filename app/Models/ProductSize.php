<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSize extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'product_sizes';

   /**
    * Get the sizeData associated with the ProductSize
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function sizeData(): HasOne
   {
       return $this->hasOne(Size::class, 'id', 'size_id');
   }
}
