<?php

namespace LegacyFcm\FcmHelper;

use LegacyFcm\FcmHelper\Jobs\SendFcmNotificationJob;
use Illuminate\Support\Facades\Log;

class FcmHelper
{
    public static function sendFcmNotification($tokens, $title, $body, $data = [])
    {
        if (empty($tokens)) {
            Log::info('No FCM tokens found for sending notifications.');
            return 0;
        }  
        SendFcmNotificationJob::dispatch($tokens, $title, $body, $data);
    }
}
