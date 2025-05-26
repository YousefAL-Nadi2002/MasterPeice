<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('rating')->comment('1-5 stars');
            $table->text('comment')->nullable();
            $table->json('aspects')->nullable()->comment('تقييم جوانب محددة مثل النظافة، الخدمة، إلخ');
            $table->timestamps();

            // منع المستخدم من تقييم نفس المحطة أكثر من مرة
            $table->unique(['user_id', 'station_id', 'booking_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
} 