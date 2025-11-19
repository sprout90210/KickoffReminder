<?php

namespace App\Infrastructure\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class FootballApiClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.api.base_uri'),
            'headers' => [
                'X-Auth-Token' => config('services.api.X_AUTH_TOKEN'),
            ],
        ]);
    }

    /**
     * GET リクエスト
     *
     * @param string $path
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $path): ResponseInterface
    {
        $response = $this->client->get($path);
        return json_decode($response->getBody());
    }
}
