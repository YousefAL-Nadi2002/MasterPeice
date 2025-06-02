<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });

        Schema::create('provider_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('service_provider_id')->constrained('service_providers')->onDelete('cascade');
            $table->unique(['service_id', 'service_provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_service');
        Schema::dropIfExists('service_providers');
    }
}; 