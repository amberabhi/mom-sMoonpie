<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoCode extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'promocodes';
    
    public function isExpired()
    {
        return $this->expiry_date < now();
    }

    public function isActive()
    {
        return $this->is_active && !$this->isExpired();
    }

}
