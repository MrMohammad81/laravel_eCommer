<?php

namespace App\Channels;

use Ghasedak\GhasedakApi;
use Illuminate\Notifications\Notification;

class SmsResetPassChannel
{
    public function send($notifiable , Notification $notification)
    {
        $userMobile = $notifiable->cellphone;
        $template = 'ResetPassword';
        $param1 = $notification->code;

        $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $api->verify($userMobile,$template,$param1);
    }
}
