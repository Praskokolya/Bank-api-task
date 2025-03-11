<?php

namespace App\Services;

use GuzzleHttp\Client;

class ExchangeService
{
    public $client;
    public $apiKey;
    public $apiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('EXCHANGE_API_KEY');
    }

    public function exchange($from, $to, $amount)
    {
        $this->apiUrl = "https://v6.exchangerate-api.com/v6/$this->apiKey/latest/$from";

        $currencies = json_decode($this->client->get($this->apiUrl)->getBody()->getContents());
        return $currencies->conversion_rates->$to * $amount;
    }
}
