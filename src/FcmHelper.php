<?php

namespace DigiNotification\FcmHelper;

use DigiNotification\FcmHelper\Jobs\SendFcmNotificationJob;
use Illuminate\Support\Facades\Log;

class FcmHelper
{
    public static function sendFcmNotification($tokens, $title, $body, $data = [])
    {
        if (empty($tokens)) {
            if (config('fcm.logging')) {
                Log::info('No FCM tokens found for sending notifications.');
            }
            return 0; // No tokens, no notification sent
        }    
        try { 
            SendFcmNotificationJob::dispatch($tokens, $title, $body, $data);
            return 1;  
        } catch (\Exception $e) {
            if (config('fcm.logging')) {
                Log::error('Failed to dispatch FCM notification job', ['error' => $e->getMessage()]);
            }
            return 0;  
        }
    }
}

