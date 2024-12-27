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
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('critic');
            $table->integer('rating');
            $table->uuid('users_id');
 
            $table->foreign('users_id')->references('id')->on('users');
            $table->uuid('movies_id');
 
            $table->foreign('movies_id')->references('id')->on('movies');
            $table->string('year');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
