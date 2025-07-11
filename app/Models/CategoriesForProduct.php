<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriesForProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $dates = [ 'deleted_at' ];
    protected $table = 'product_categories';

}
