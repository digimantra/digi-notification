<?php
namespace YourNamespace\FcmHelper;

use Google\Client as GoogleClient;
use Google\Service\FirebaseCloudMessaging;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmHelper
{
    public static function sendFcmNotification($tokens, $title, $body, $data = [])
    {
        $firebaseProjectId = config('fcm.project_id');
        $url = "https://fcm.googleapis.com/v1/projects/{$firebaseProjectId}/messages:send";

        try {
            $client = new GoogleClient();
            $client->setAuthConfig(config('fcm.credentials_path'));
            $client->addScope(FirebaseCloudMessaging::FIREBASE_MESSAGING);
            $client->addScope(FirebaseCloudMessaging::CLOUD_PLATFORM);
            $accessToken = $client->fetchAccessTokenWithAssertion();

            if (is_array($accessToken) && isset($accessToken['access_token'])) {
                $accessToken = $accessToken['access_token'];
                $validTokens = array_filter($tokens, fn($token) => !empty($token));

                if (!empty($validTokens)) {
                    foreach ($validTokens as $token) {
                        try {
                            $response = Http::withToken($accessToken)
                                ->acceptJson()
                                ->post($url, [
                                    'message' => [
                                        'token' => $token,
                                        'notification' => [
                                            'title' => $title,
                                            'body' => $body,
                                        ],
                                        'data' => $data,
                                    ]
                                ]);

                            $responseJson = $response->json();
                            Log::info('FCM response', ['response' => $responseJson]);
                            if (isset($responseJson['error'])) {
                                Log::error('FCM error', ['error' => $responseJson['error']]);
                            } else {
                                Log::info('FCM message sent successfully');
                            }
                        } catch (\Exception $e) {
                            Log::error('Error sending FCM notification for token', [
                                'token' => $token,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                } else {
                    Log::info('No valid FCM tokens found.');
                }
            } else {
                Log::error('Failed to fetch access token.');
            }
        } catch (\Exception $e) {
            Log::error('Error initializing Google Client', ['error' => $e->getMessage()]);
        }
    }
}
