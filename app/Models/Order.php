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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
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

    public function getPaymentStatusAttribute($status)
    {
        switch ($status)
        {
            case '0' :
                $status = 'ناموفق';
                break;

            case '1' :
                $status = 'موفق';
                break;
        }
        return $status;
    }

    public function getPaymentTypeAttribute($paymentType)
    {
        switch ($paymentType)
        {
            case 'online' :
                $paymentType = 'اینترنتی';
                break;

            case 'pos' :
                $paymentType = 'کارتخوان';
                break;

                case 'cartToCart' :
                    $paymentType = 'کارت به کارت';
                break;
        }
        return $paymentType;
    }
}
