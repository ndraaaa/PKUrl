<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('page_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('destination_url');
            $table->string('short_code')->collation('utf8mb4_bin')->unique();
            $table->string('type')->default('link');
            $table->integer('order')->default(0);
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(true); // Untuk on/off manual
            $table->timestamp('expires_at')->nullable(); // [BARU] Kapan link mati otomatis
            $table->unsignedBigInteger('click_count')->default(0);
            $table->timestamps();
            $table->index(['user_id', 'page_id']);
            $table->index('short_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
