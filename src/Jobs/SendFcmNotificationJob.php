<?php 
namespace LegacyFcm\FcmHelper\Jobs;

use Google\Client as GoogleClient;
use Google\Service\FirebaseCloudMessaging;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendFcmNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tokens;
    protected $title;
    protected $body;
    protected $data;

    public function __construct($tokens, $title, $body, $data = [])
    {
        $this->tokens = $tokens;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    public function handle()
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
                $validTokens = array_filter($this->tokens, fn($token) => !empty($token));

                if (!empty($validTokens)) {
                    foreach ($validTokens as $token) {
                        try {
                            $response = Http::withToken($accessToken)
                                ->acceptJson()
                                ->post($url, [
                                    'message' => [
                                        'token' => $token,
                                        'notification' => [
                                            'title' => $this->title,
                                            'body' => $this->body,
                                        ],
                                        'data' => $this->data,
                                    ]
                                ]);

                            $responseJson = $response->json();
                            Log::info('FCM response', ['response' => $responseJson]);
                            if (isset($responseJson['error'])) {
                                Log::error('FCM error', ['error' => $responseJson['error']]);
                                return 0;
                            }
                        } catch (\Exception $e) {
                            Log::error('Error sending FCM notification for token', [
                                'token' => $token,
                                'error' => $e->getMessage(),
                            ]);
                            return 0;
                        }
                    }
                } else {
                    Log::info('No valid FCM tokens found.');
                }

                return 1; // Success
            } else {
                Log::error('Failed to fetch access token.');
                return 0;
            }
        } catch (\Exception $e) {
            Log::error('Error initializing Google Client', ['error' => $e->getMessage()]);
            return 0;
        }
    }
}
