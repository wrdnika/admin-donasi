<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SupabaseService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('supabase.url') . "/rest/v1/";
        $this->apiKey = config('supabase.api_key');
        $this->client = new Client([
            'headers' => [
                'apikey' => $this->apiKey,
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function getData($table, $filters = [])
    {
        try {
            $url = $this->baseUrl . $table;
            $response = $this->client->get($url, [
                'query' => $filters
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function insertData($table, $data)
    {
        try {
            $url = $this->baseUrl . $table;
            $response = $this->client->post($url, [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
