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
        Schema::create('hotel_resorts', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('description');
            $table->string('accommodation');
            $table->decimal('price', 10, 2);
            $table->string('amenities');
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('type', ['hotel', 'resort']);
            $table->json('images');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_resorts');
    }
};
