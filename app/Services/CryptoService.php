<?php

namespace App\Services;

use App\Models\Crypto;
use App\Models\User;
use App\Repositories\CoinMarketCapApiRepository;

class CryptoService
{
    public function getCryptoList()
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $parameters = [
            'start' => '1',
            'limit' => '10',
            'convert' => 'EUR'
        ];

        return (new CoinMarketCapApiRepository())->getCryptoCoins($url, $parameters)['data'];
    }

    public function getCryptoById(int $coinId): array
    {
        $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $parameters = [
            'convert' => 'EUR',
            'id' => $coinId
        ];

        $response = (new CoinMarketCapApiRepository())->getCryptoCoins($url, $parameters);

        if (!isset($response['data'][$coinId])) {
            return [];
        }

        return $response['data'][$coinId];
    }

    public function getCryptoBySymbol(string $cryptoSymbol): array
    {
        $cryptoSymbol = strtoupper($cryptoSymbol);
        $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $parameters = [
            'convert' => 'EUR',
            'symbol' => $cryptoSymbol
        ];

        $response = (new CoinMarketCapApiRepository())->getCryptoCoins($url, $parameters);

        if (!isset($response['data'][$cryptoSymbol])) {
            return [];
        }

        return $response['data'][$cryptoSymbol];
    }

    public function getCryptoIdBySlug(string $cryptoSlug): int
    {
        $cryptoSlug = strtolower($cryptoSlug);
        $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $parameters = [
            'convert' => 'EUR',
            'slug' => $cryptoSlug
        ];

        $response = (new CoinMarketCapApiRepository())->getCryptoCoins($url, $parameters);

        if (!isset($response['data'])) {
            return false;
        }
        $id = array_keys($response['data']);

        return $id[0];
    }

    public function saveCrypto(string $accountNumber, string $symbol, float $price, float $amount, User $user)
    {
        $crypto = Crypto::where('account_number', $accountNumber)->where('symbol', $symbol)->first();

        if ($crypto) {
            $crypto->update([
                'amount' => $amount,
                'price' => $price,
            ]);
        } else {
            $crypto = (new Crypto())->fill([
                'account_number' => $accountNumber,
                'symbol' => $symbol,
                'price' => $price,
                'amount' => $amount,
            ]);
            $crypto->user()->associate($user);
            $crypto->save();
        }
        if($crypto->amount == 0) {
            $crypto->delete();
        }
    }
}
