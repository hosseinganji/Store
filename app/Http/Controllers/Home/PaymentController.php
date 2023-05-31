<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $request->validate([
            "address_id" => "required|not_in:select",
            "payment" => "required",

        ]);

        $total_amount = \Cart::getTotal() + discountAmountTotalInCart();
        $delivery_amount = sendAmountTotalInCart();
        $paying_amount = \Cart::getTotal() + sendAmountTotalInCart();


        dd($request->all() , $total_amount , $delivery_amount , $paying_amount);


        $api = 'test';
        $amount = "10000";
        $mobile = "09123456789";
        $factorNumber = "1245";
        $description = "ندارد";
        $redirect = route('home.payment.callback');
        $result = $this->send($api, $amount, $redirect, $mobile, $factorNumber, $description);
        $result = json_decode($result);
        if($result->status) {
            $go = "https://pay.ir/pg/$result->token";
            return redirect()->to($go);
        } else {
            echo $result->errorMessage;
        }
    }

    public function paymentCallback(Request $request)
    {
        $api = 'test';
        $token = $request->token;//$_GET['token'];
        $result = json_decode($this->verify($api,$token));
        if(isset($result->status)){
            if($result->status == 1){
                echo "<h1>تراکنش با موفقیت انجام شد</h1>";
            } else {
                echo "<h1>تراکنش با خطا مواجه شد</h1>";
            }
        } else {
            if($_GET['status'] == 0){
                echo "<h1>تراکنش با خطا مواجه شد</h1>";
            }
        }
    }

    public function send($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null) {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api'          => $api,
            'amount'       => $amount,
            'redirect'     => $redirect,
            'mobile'       => $mobile,
            'factorNumber' => $factorNumber,
            'description'  => $description,
        ]);
    }

    public function verify($api, $token) {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' 	=> $api,
            'token' => $token,
        ]);
    }

    public function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
    
        return $res;
    }
}
