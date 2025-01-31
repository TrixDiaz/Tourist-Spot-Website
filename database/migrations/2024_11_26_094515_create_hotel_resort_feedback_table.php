<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotel_resort_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_resort_id');
            $table->unsignedBigInteger('user_id');
            $table->string('comment');
            $table->integer('rating');
            $table->boolean('is_active')->default(true);
            $table->foreign('hotel_resort_id')->references('id')->on('hotel_resorts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_resort_feedback');
    }
};
