<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'orders';

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusAttribute($status)
    {
        switch ($status)
        {
            case '0' :
                $status = 'در انتظار پرداخت';
                break;

            case '1' :
                $status = ' پرداخت شده';
                break;
        }
        return $status;
    }
}
