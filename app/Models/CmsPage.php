<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsPage extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'cms_pages';
    protected $guarded = ['id'];
}
