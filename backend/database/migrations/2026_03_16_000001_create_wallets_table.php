<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('wallets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->enum('type', ['sprayer', 'host']); // Wallet type per user
      $table->enum('currency', ['NGN', 'USD'])->default('NGN');
      $table->decimal('balance', 15, 2)->default(0.00);
      $table->decimal('locked_balance', 15, 2)->default(0.00); // Funds in escrow
      $table->timestamps();

      $table->unique(['user_id', 'type', 'currency']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('wallets');
  }
};
