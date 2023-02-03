<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptosTable extends Migration
{
    private const TABLE_NAME = 'cryptos';

    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('account_number');
            $table->string('symbol');
            $table->decimal('price', 16);
            $table->decimal('amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cryptos');
    }
}
