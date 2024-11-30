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
        Schema::create('news_event_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_resort_id');
            $table->string('name');
            $table->string('slug');
            $table->string('description');
            $table->string('images');
            $table->boolean('is_active')->default(true);
            $table->foreign('hotel_resort_id')->references('id')->on('hotel_resorts')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_event_categories');
    }
};
