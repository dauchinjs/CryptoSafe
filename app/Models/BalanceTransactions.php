<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'user_name',
        'amount',
        'currency',
        'type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountFormattedAttribute(): string
    {
        return number_format($this->amount / 100, 2);
    }

    public function getDateFormattedAttribute(): string
    {
        return date("Y-m-d", strtotime($this->created_at));
    }

    public function getTimeFormattedAttribute(): string
    {
        return date("H:i:s", strtotime($this->created_at));
    }
}
