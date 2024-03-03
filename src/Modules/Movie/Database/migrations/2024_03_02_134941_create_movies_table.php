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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->string('imdb_thumbnail')->nullable();
            $table->unsignedDecimal('price');
            $table->string('imdb_id')->nullable();
            $table->string('imdb_rating')->nullable();
            $table->foreignId('video_id')->constrained('media')->cascadeOnDelete();
            $table->foreignId('thumbnail_id')->constrained('media')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
