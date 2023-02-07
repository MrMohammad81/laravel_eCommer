<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = [];
    protected $table = 'coupons';

    public function getTypeAttribute($type)
    {
        return $type == 'amount' ? 'مبلغی' : 'درصدی' ;
    }

}
