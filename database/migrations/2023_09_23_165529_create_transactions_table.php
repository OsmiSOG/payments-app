<?php

use App\Enums\TransactionCurrency;
use App\Enums\TransactionMethods;
use App\Enums\TransactionNetwork;
use App\Enums\TransactionStatus;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double('amount', 14, 2);
            $table->string('description');
            $table->enum('status', array_column(TransactionStatus::cases(), 'value'))->default(TransactionStatus::Init->value);
            $table->enum('currency', array_column(TransactionCurrency::cases(), 'value'));
            $table->enum('payment_method', array_column(TransactionMethods::cases(), 'value'));
            $table->enum('network', array_column(TransactionNetwork::cases(), 'value'));
            $table->string('card_label');
            $table->string('reference_1');
            $table->string('reference_2');
            $table->string('reference_3');
            $table->dateTime('status_at');
            $table->boolean('tokenized');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('client_id')->constrained('clients');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
