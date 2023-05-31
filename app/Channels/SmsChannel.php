<?php

namespace App\Channels;
use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Notifications\Notification;

class SmsChannel{
    public function send($notifiable , Notification $notification)
    {
        // return "Done";

        $receptor = $notifiable->cellphone;
        $template = "password";
        $parametr1 = $notification->code;
        
        $response = GhasedakFacade::setVerifyType(GhasedakFacade::VERIFY_MESSAGE_TEXT);
        $response->Verify( $receptor , $template , $parametr1);  
    }
}