<?php

namespace App\Channels;

use Ghasedak\GhasedakApi;
use Illuminate\Notifications\Notification;

class SmsLoginChannel
{
    public function send($notifiable , Notification $notification)
    {
        $userMobile = $notifiable->cellphone;
        $template = 'OTP';
        $param1 = $notification->code;

        $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $api->verify($userMobile,$template,$param1);
    }
}
