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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('handle')->unique();
            $table->string('title')->default('Halaman Saya');
            $table->string('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('theme')->default('default');
            $table->timestamps();
        });
    }
};
