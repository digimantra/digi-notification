<?php

namespace LegacyFcm\FcmHelper;

use LegacyFcm\FcmHelper\Jobs\SendFcmNotificationJob;
use Illuminate\Support\Facades\Log;
use LegacyFcm\FcmHelper\Models\PushNotification;

class FcmHelper
{
    public static function sendFcmNotification($tokens, $title, $body, $data = [], $type)
    {
        if (empty($tokens)) {
            if (config('fcm.logging')) {
                Log::info('No FCM tokens found for sending notifications.');
            }
            return 0; // No tokens, no notification sent
        }    
        try { 
            SendFcmNotificationJob::dispatch($tokens, $title, $body, $data);
            $params = [
                'title' => $title,
                'content' => $body,
                'data' => $data,
                'type' => $type,
                'created_at' => now(),
            ];
            PushNotification::insert([$params]);
            return 1;  
        } catch (\Exception $e) {
            if (config('fcm.logging')) {
                Log::error('Failed to dispatch FCM notification job', ['error' => $e->getMessage()]);
            }
            return 0;  
        }
    }
}