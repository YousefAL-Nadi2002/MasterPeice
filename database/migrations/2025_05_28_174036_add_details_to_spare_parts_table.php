<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            $table->string('part_type')->nullable();
            $table->string('condition')->nullable();
            $table->string('compatible_with')->nullable();
            $table->text('extra_description')->nullable();
            $table->string('seller_name')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->json('images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            $table->dropColumn(['part_type', 'condition', 'compatible_with', 'extra_description', 'seller_name', 'location', 'phone', 'whatsapp', 'email', 'images']);
        });
    }
}
