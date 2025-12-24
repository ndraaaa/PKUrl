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
        Schema::create('links', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Siapa pemilik link ini)
            // onDelete('cascade') artinya jika user dihapus, link-nya ikut terhapus
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Judul Link (Penting untuk tampilan di Halaman Bio)
            $table->string('title')->nullable();

            // URL Asli tujuan (Destinasi)
            $table->text('original_url');

            // Kode Unik (misal: bit.ly/Xy7Z1)
            $table->string('short_code')->unique();

            // Tipe Link: 
            // 'shortlink' = Link biasa (Bitly)
            // 'biolink'   = Link yang tampil di profil (Lynk.id)
            $table->enum('type', ['shortlink', 'biolink'])->default('shortlink');

            // Statistik sederhana
            $table->unsignedBigInteger('click_count')->default(0);

            // Status aktif/tidak
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
