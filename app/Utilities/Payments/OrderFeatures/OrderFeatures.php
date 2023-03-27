<?php

namespace App\Utilities\Payments\OrderFeatures;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use App\Models\Transaction;
use App\Services\Sessions\SessionService;
use App\Utilities\Validators\Auth\AuthValidator;
use Illuminate\Support\Facades\DB;

class OrderFeatures
{
    public static function createOrder($addressId , $amount , $token , $gatewayName)
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => AuthValidator::getUserId(),
                'user_ip' => AuthValidator::getUserIp(),
                'address_id' => $addressId,
                'coupon_id' => SessionService::findSession('coupon') ? SessionService::getSession('coupon.id') : null,
                'total_amount' => $amount['total_amount'],
                'delivery_amount' => $amount['delivery_amount'],
                'paying_amount' => $amount['paying_amount'],
                'payment_type' => 'online'
            ]);

            foreach (\Cart::getContent() as $item)
            {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' =>  $item->associatedModel->id,
                    'product_variation_id' => $item->attributes->id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->price,
                ]);

                Transaction::create([
                    'user_id' => AuthValidator::getUserId(),
                    'user_ip' => AuthValidator::getUserIp(),
                    'order_id' => $order->id,
                    'amount' => $amount['paying_amount'],
                    'token' => $token,
                    'gateway_name' => $gatewayName
                ]);
            }

            DB::commit();
        }catch (\Exception $exception)
        {
            DB::rollBack();

            return ['error' => $exception->getMessage()];
        }
        return ['success' => 'success!!'];
    }

    public static function updateOrder($token , $refId)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::where('token' , $token)->firstOrFail();

            $transaction->update([
                'status' => 1,
                'ref_id' => $refId
            ]);

            $order = Order::findOrFail($transaction->order_id);

            $order->update([
                'payment_status' => 1,
                'status' => 1
            ]);

            foreach (\Cart::getContent() as $item)
            {
                $variation = ProductVariation::find($item->attributes->id);

                $variation->update([
                    'quantity' => $variation->quantity - $item->quantity
                ]);
            }

            DB::commit();
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return ['error' => $exception->getMessage()];
        }
        return ['success' => 'success!!'];
    }
}
