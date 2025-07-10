<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\TokenFcm;
use Illuminate\Support\Facades\Log;

class FcmNotificationService
{
    protected string $serverKey;

    public function __construct()
    {
        $this->serverKey = config('services.fcm.key');
    }

    public function sendToUser(string $userId, string $title, string $body, array $data = []): array
    {
        $tokens = TokenFcm::where('user_id', $userId)->pluck('token')->filter()->unique();

        if ($tokens->isEmpty()) {
            return ['success' => false, 'message' => 'Aucun token FCM trouvé pour cet utilisateur.'];
        }

        $responses = [];

        foreach ($tokens as $token) {
            $response = Http::withHeaders([
                'Authorization' => "key=$this->serverKey",
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                        'to' => $token,
                        'notification' => [
                            'title' => $title,
                            'body' => $body,
                            'sound' => 'default',
                        ],
                        'data' => array_merge([
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        ], $data),
                    ]);

            Log::info("FCM response for user $userId", $response->json());

            $responses[] = [
                'token' => $token,
                'status' => $response->status(),
                'response' => $response->json(),
            ];
        }

        return ['success' => true, 'responses' => $responses];
    }
}
