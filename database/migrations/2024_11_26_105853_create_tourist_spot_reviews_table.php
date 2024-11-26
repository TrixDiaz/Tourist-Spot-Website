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
        Schema::create('tourist_spot_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tourist_spot_id');
            $table->unsignedBigInteger('user_id');
            $table->string('comment');
            $table->integer('rating');
            $table->foreign('tourist_spot_id')->references('id')->on('tourist_spots')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_spot_reviews');
    }
};
