<?php

namespace App\Services;

use GuzzleHttp\Client;

class LineMessagingService
{
    protected $client;

    protected $accessToken;

    protected $apiEndpoint = 'https://api.line.me/v2/bot/message/push';

    public function __construct()
    {
        $this->client = new Client();
        $this->accessToken = env('LINE_MESSAGE_CHANNEL_TOKEN');
    }

    public function sendMessage($lineUserId, $message)
    {
        $data = [
            'to' => $lineUserId,
            'messages' => [
                ['type' => 'text', 'text' => $message],
            ],
        ];

        $response = $this->client->post($this->apiEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($data),
        ]);

        return $response;
    }
}
