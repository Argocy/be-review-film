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
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('summary');
            $table->string('poster')->nullable();
            $table->year('year');
            $table->uuid('genres_id');
            
 
            $table->foreign('genres_id')->references('id')->on('genres');
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