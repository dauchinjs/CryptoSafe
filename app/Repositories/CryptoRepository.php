<?php

namespace App\Repositories;

interface CryptoRepository
{
    public function getCryptoCoins($url, $parameters): array;
}
