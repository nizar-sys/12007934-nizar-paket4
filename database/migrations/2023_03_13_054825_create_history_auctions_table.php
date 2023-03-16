<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_auctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_id');
            $table->foreign('auction_id')->references('id')->on('auctions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('bidder_id');
            $table->foreign('bidder_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('price_quote');
            $table->enum('status', ['diterima', 'ditolak', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_auctions');
    }
};
