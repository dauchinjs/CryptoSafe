<?php

namespace App\Services;

class CurrencyConversionService
{
    public function getCurrencyConversion(string $fromCurrency, string $toCurrency, float $amount)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=$toCurrency&from=$fromCurrency&amount=$amount",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: " . config('services.currency.key')
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }
}
