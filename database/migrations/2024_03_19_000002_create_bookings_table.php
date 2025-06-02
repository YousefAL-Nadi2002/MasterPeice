<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->dateTime('start_time');
            $table->integer('duration'); // بالساعات
            $table->string('charger_type');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->decimal('total_price', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};