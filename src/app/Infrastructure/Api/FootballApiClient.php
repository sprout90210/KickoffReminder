<?php

namespace App\Infrastructure\Api;

use App\Exceptions\TooManyRequestsException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class FootballApiClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://api.football-data.org/v4/',
            'headers' => [
                'X-Auth-Token' => config('services.api.X_AUTH_TOKEN'),
                'Accept'       => 'application/json',
            ],
        ]);
    }

    /**
     * GET request
     *
     * @param string $path
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $path): ResponseInterface
    {
        $path = ltrim($path, '/');
        try {
            return $this->client->get($path);
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {            
            // APIのリミットにかかった場合だけthrowする
            if ($e->getResponse() && $e->getResponse()->getStatusCode() === 429) {
                throw new TooManyRequestsException(
                    "API rate limit exceeded (429): {$path}",
                    429,
                    $e
                );
            }

            // 429 以外はそのまま投げる
            throw $e;
        }
    }
}
