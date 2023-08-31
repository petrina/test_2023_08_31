<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_wallet_id');
            $table->decimal('count', 8, 3, true);
            $table->decimal('price', 8, 3, true);
            $table->unsignedBigInteger('currency_id');
            $table->decimal('fee', 8, 3, true);
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->timestamps();

            $table->foreign('seller_wallet_id')->references('id')->on('wallets');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('buyer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell');
    }
};
