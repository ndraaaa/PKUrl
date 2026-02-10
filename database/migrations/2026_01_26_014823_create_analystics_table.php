<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->char('country_code', 2)->nullable();
            $table->string('city')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->text('referer')->nullable();
            $table->timestamps();
            $table->index(['link_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};
