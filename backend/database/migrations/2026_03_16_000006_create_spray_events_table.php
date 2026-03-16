<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('spray_events', function (Blueprint $table) {
      $table->id();
      $table->foreignId('spray_session_id')->constrained()->cascadeOnDelete();
      $table->foreignId('sprayer_id')->constrained('users')->cascadeOnDelete();

      // Note denomination
      $table->enum('currency', ['NGN', 'USD']);
      $table->decimal('denomination', 10, 2); // e.g. 200, 500, 1000, 1, 100

      // Quantity type
      $table->enum('quantity_type', ['single', 'five', 'bundle']);
      $table->integer('note_count');             // Actual number of notes sprayed
      $table->decimal('total_amount', 15, 2);   // denomination × note_count

      // Linked escrow
      $table->foreignId('escrow_id')->constrained()->cascadeOnDelete();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('spray_events');
  }
};
