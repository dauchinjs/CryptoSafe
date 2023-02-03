<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'balance',
        'currency',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    public function getCurrencySymbolAttribute(): string
//    {
//        if($this->currency == 'EUR') {
//            return '€';
//        }
//        return '$';
//    }

    public function getBalanceFormattedAttribute(): string
    {
        return number_format($this->balance / 100, 2);
    }

    public function getCurrenciesAttribute(): array
    {
        $xml = simplexml_load_string(file_get_contents('https://www.bank.lv/vk/xml.xml?date=20010323'));
        $currencies = $xml->Currencies->Currency;
        $ids = array();
        foreach ($currencies as $currency) {
            $ids[] = (string)$currency->ID;
        }
        return $ids;
    }
}
