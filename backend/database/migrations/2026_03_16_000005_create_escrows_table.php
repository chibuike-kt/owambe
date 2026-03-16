<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('escrows', function (Blueprint $table) {
      $table->id();
      $table->foreignId('spray_session_id')->constrained()->cascadeOnDelete();
      $table->enum('currency', ['NGN', 'USD'])->default('NGN');
      $table->decimal('balance', 15, 2)->default(0.00);
      $table->enum('status', ['holding', 'settled'])->default('holding');
      $table->timestamp('settled_at')->nullable();
      $table->timestamps();

      $table->unique(['spray_session_id', 'currency']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('escrows');
  }
};
