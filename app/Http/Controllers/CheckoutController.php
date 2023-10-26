<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;



class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        //save user data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        //process checkout
        $code = 'STORE-' . mt_rand(00000000, 99999999);
        $carts = Cart::with('product', 'user')->where('users_id', Auth::user()->id)->get();

        //transaction create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'inscurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code,

        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(00000000, 99999999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx,
            ]);
        }

        //Deleting Cart Data
        Cart::where('users_id', Auth::user()->id)->delete();

        //Configuration Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //create array for sending to midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payment' => [
                'gopay',
                'permata_va',
                'bank_transfer',
            ],
            'vtweb' => [],
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function callback(Request $request)
    {
        //set configuration midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //intance midtrans notification
        $notification = new Notification();

        //assign to variable
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        //find transaction by id
        $transaction = Transaction::findOrFail($order_id);

        //handle notification
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->status = 'PENDING';
                } else {
                    $transaction->status = 'SUCCESS';
                }
            }
        } elseif ($status == 'settlement') {
            $transaction->status = 'SUCCESS';
        } elseif ($status == 'pending') {
            $transaction->status = 'PENDING';
        } elseif ($status == 'deny') {
            $transaction->status = 'CANCELLED';
        } elseif ($status == 'expire') {
            $transaction->status = 'CANCELLED';
        } elseif ($status == 'cancel') {
            $transaction->status = 'CANCELLED';
        }
        //save transaction
        $transaction->save();
    }
}
