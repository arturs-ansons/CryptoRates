<?php

declare(strict_types=1);

namespace App;

use App\Models\Coin;
use App\Models\CoinCollection;
use GuzzleHttp\Client;

class ApiService
{
    private Client $client;
    private CoinCollection $coinCollection;

    public function __construct()
    {
        $this->client = new Client();
        $this->coinCollection = new CoinCollection();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchCoins(): CoinCollection
    {
        if (empty($this->coinCollection->getCoinCollection())) {
            $apiKey = $_ENV['API_KEY'];
            $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/category';
            $parameters = [
                'id' => '605e2ce9d41eae1066535f7c',
            ];
            $response = $this->client->get($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'X-CMC_PRO_API_KEY' => $apiKey,
                ],
                'query' => $parameters,
            ]);

            $data = json_decode((string)$response->getBody(), true);

            foreach ($data['data']['coins'] as $coinData) {
                $coin = new Coin(
                    $coinData['id'],
                    $coinData['name'],
                    $coinData['quote']['USD']['price'] ?? null,
                );

                $this->coinCollection->add($coin);
            }
        }

        return $this->coinCollection;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchCoins($searchCoin): ?CoinCollection
    {
       $this->fetchCoins();

        $matchingCoins = new CoinCollection();
        $searchCoin = trim($searchCoin);

        foreach ($this->coinCollection->getCoinCollection() as $coin) {
            $coinName = trim($coin->getName());

            if (stripos($coinName, $searchCoin) !== false) {
                $matchingCoins->add($coin);
            }
        }

        return count($matchingCoins->getCoinCollection()) > 0 ? $matchingCoins : null;
    }
}
