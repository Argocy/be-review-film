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
        Schema::table('casts', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('cast__movies', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('movies', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('casts', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('cast__movies', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('movies', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
