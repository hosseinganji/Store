<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OTPSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->method() == "GET"){
            return view('home.auth.login');
        }

        
        $request->validate([
            // 'cellphone' => 'required|iran_mobile'
            'cellphone' => 'required|digits:11|regex:/[0]{1}[0-9]{10}/'
        ]);
        
        // echo($request->cellphone); 

        try {
            $user = User::where('cellphone' , $request->cellphone)->first();
        
            $OTPCode = mt_rand(10000 , 99999);
            $loginToken = Hash::make("HSBDS*&knmlk^*jkoij%fgfdeg&fd$");
            
            if($user){
                $user->update([
                    "otp" => $OTPCode,
                    "login_token" => $loginToken
                ]);

            }else{
                $user = User::Create([
                    "cellphone" => $request->cellphone,
                    "otp" => $OTPCode,
                    "login_token" => $loginToken
                ]);
                
            }
            $user->notify(new OTPSms($OTPCode));

            

            return response(['login_token' => $loginToken] , 200);

        } catch (\Exception $ex) {
            return response(['errors' => $ex] , 422);
        }
    
        
    }


    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:5',
            'login_token' => 'required'
        ]);

        try{
            $user = User::where('login_token' , $request->login_token)->firstOrFail();

            if($request->otp == $user->otp){
                auth()->login($user , $remember = true);
                return response(['ورود با موفقیت انجام شد'] , 200);
            }else{
                return response(["errors" => ["otp" => ['کد وارد شده نادرست می باشد']]] , 422);
            }

        } catch (\Exception $ex) {
            return response(['errors' => $ex] , 422);
        }


    }

    public function resendOtp(Request $request)
    {
        try {
            $user = User::where('login_token' , $request->login_token)->firstOrFail();
        
            $OTPCode = mt_rand(10000 , 99999);
            $loginToken = Hash::make("HSBDS*&knmlk^*jkoij%fgfdeg&fd$");
            
            $user->update([
                "otp" => $OTPCode,
                "login_token" => $loginToken
            ]);

            $user->notify(new OTPSms($OTPCode));

            return response(['login_token' => $loginToken] , 200);

        } catch (\Exception $ex) {
            return response(['errors' => $ex] , 422);
        }
    }

    public function logout()
    {
        auth()->logout();
        alert()->success('موفق' , 'شما با موفقیت خارج شدید')->persistent("بستن");
        return redirect()->to(route("home.homepage"));
    }
}
