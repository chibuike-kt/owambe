<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('spray_sessions', function (Blueprint $table) {
      $table->id();
      $table->ulid('session_code')->unique(); // Shareable code for QR/link
      $table->foreignId('host_id')->constrained('users')->cascadeOnDelete();
      $table->string('event_name');
      $table->enum('status', ['active', 'paused', 'closed'])->default('active');
      $table->string('qr_code_path')->nullable(); // Path to stored QR image
      $table->timestamp('closed_at')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('spray_sessions');
  }
};
