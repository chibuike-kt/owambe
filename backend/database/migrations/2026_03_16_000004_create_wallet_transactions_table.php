<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('wallet_transactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();

      // Transaction classification
      $table->enum('type', [
        'fund',          // DevWallet top-up → sprayer wallet
        'spray',         // Sprayer wallet → escrow
        'escrow_credit', // Escrow receives spray
        'settle',        // Escrow → host wallet
      ]);

      $table->enum('currency', ['NGN', 'USD']);
      $table->decimal('amount', 15, 2);             // Raw amount
      $table->decimal('credits_received', 15, 2)->nullable(); // After margin deduction
      $table->decimal('platform_fee', 15, 2)->nullable();     // Fee taken

      // Reference links
      $table->foreignId('spray_session_id')->nullable()->constrained()->nullOnDelete();
      $table->string('devwallet_reference')->nullable(); // External payment ref

      $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('wallet_transactions');
  }
};
