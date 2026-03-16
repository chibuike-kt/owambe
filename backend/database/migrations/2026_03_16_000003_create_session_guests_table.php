<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    // Tracks which users have joined which spray sessions
    Schema::create('session_guests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('spray_session_id')->constrained()->cascadeOnDelete();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->timestamp('joined_at')->useCurrent();
      $table->timestamps();

      $table->unique(['spray_session_id', 'user_id']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('session_guests');
  }
};
