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
        Schema::create('news_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_event_category_id');
            $table->string('title');
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->foreign('news_event_category_id')->references('id')->on('news_event_categories');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_events');
    }
};
