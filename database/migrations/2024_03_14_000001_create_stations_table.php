<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active')->index();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('available_ports')->default(0);
            $table->integer('total_ports')->default(0);
            $table->json('charging_types')->nullable();
            $table->json('operating_hours')->nullable();
            $table->json('amenities')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stations');
    }
} 