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
        Schema::table('links', function (Blueprint $table) {
            // Tambah kolom page_id
            $table->foreignId('page_id')->nullable()->after('id')->constrained()->onDelete('cascade');

            // Hapus foreign key user_id (karena link sekarang milik page, bukan user langsung)
            // Kita buat nullable dulu biar data lama gak error, nanti bisa dihapus total
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
