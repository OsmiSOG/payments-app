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
        Schema::create('card_tokenizeds', function (Blueprint $table) {
            $table->uuid();
            $table->string('number');
            $table->string('cvv');
            $table->string('holder');
            $table->string('datetime');
            $table->string('franchise');
            $table->string('number_label');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_tokenizeds');
    }
};
