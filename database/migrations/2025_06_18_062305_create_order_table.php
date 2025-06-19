<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->string('card_holder_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_expiration')->nullable();
            $table->string('card_cvv')->nullable();
            $table->string('pix_key')->nullable();
            $table->integer('installments')->nullable();
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
