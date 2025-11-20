<?php

namespace App\Services;

use App\Constants\Constants;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * LINE Messaging API を利用してユーザーにメッセージを送信するサービスクラス.
 *
 * LINE の Push Message を行うためのラッパーとして動作し、
 * GuzzleHttp クライアントを内部的に利用してリクエストを送信する。
 */
class LineMessagingService
{
    /**
     * @var Client HTTP クライアント（Guzzle）
     */
    protected Client $client;

    /**
     * @var string LINE Messaging API のチャネルアクセストークン
     */
    protected string $accessToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->accessToken = (string) env('LINE_MESSAGE_CHANNEL_TOKEN', '');
    }

    /**
     * 指定された LINE ユーザーにテキストメッセージを送信する
     *
     * @param string $line_user_id 送信先の LINE User ID
     * @param string $message      送信するテキストメッセージ
     *
     * @return ResponseInterface LINE API が返す HTTP レスポンス
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendMessage(string $line_user_id, string $message): ResponseInterface
    {
        $data = [
            'to' => $line_user_id,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $message,
                ],
            ],
        ];

        return $this->client->post(Constants::LINE_API_BASE_URI, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE),
        ]);
    }
}
