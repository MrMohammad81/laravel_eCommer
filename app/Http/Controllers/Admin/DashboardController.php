<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $paiedOrders = Order::where('payment_status' , 1)->get();
        $total_amount = $this->getTotalAmount($paiedOrders);
        $orderAwaitingPayment = Order::where('payment_status' , 0)->get();

        $products = ProductVariation::where('sku' , '>' , 1)->get();

        $comments = Comment::where('approved' , 1)->get();

        $successfulTransactions = $this->getSuccessfulTransaction();
        $failedTransactions = $this->getFailedTransactions();

        $activeCoupons = $this->getActiveCoupons();

        $users = User::all();

        return view('admin.dashboard',compact('orderAwaitingPayment','users','activeCoupons','paiedOrders' , 'total_amount' , 'products' , 'comments' , 'successfulTransactions' , 'failedTransactions'));
    }

    private function getTotalAmount($orders)
    {
        $total_amount = 0;
        foreach ($orders as $order)
        {
            $total_amount += $order->total_amount;
        }
        return $total_amount;
    }

    private function getSuccessfulTransaction()
    {
        $transaction = Transaction::where('status' , 1)->get();
        return $transaction;
    }

    private function getFailedTransactions()
    {
        $transaction = Transaction::where('status' , 0)->get();
        return $transaction;
    }

    private function getActiveCoupons()
    {
        $coupon = Coupon::where('expired_at' , '>' , Carbon::now())->get();
        return $coupon;
    }

    private function getOrderAwaitingPayment()
    {

    }
}
