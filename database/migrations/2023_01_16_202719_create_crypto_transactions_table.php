<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoTransactionsTable extends Migration
{
    private const TABLE_NAME = 'crypto_transactions';

    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('account_number');
            $table->string('user_name')->nullable();
            $table->decimal('price', 16)->nullable();
            $table->decimal('amount');
            $table->string('symbol');
            $table->float('profit')->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crypto_transactions');
    }
}
