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
        Schema::disableForeignKeyConstraints();

        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title', 100)->unique();
            $table->string('slug', 100);
            $table->enum('category', ["villa", "apartment", "agriturismo", "baita", "castello", "loft", "mobile house"]);
            $table->integer('price');
            $table->text('description')->nullable();
            $table->integer('num_rooms');
            $table->integer('num_beds');
            $table->integer('num_bathrooms');
            $table->decimal('square_meters', 5, 2);
            $table->string('full_address', 255);
            $table->decimal('latitude', 15, 13);
            $table->decimal('longitude', 15, 13);
            $table->string('cover_image', 255);
            $table->boolean('is_available');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
