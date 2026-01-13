<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'page_id',
        'title',
        'original_url',
        'short_code',
        'type',
        'click_count',
        'is_active',
        'qr_path',
        'order',
    ];

    // Relasi: Link ini milik User siapa?
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     * Disini kita pasang logika otomatisnya.
     */
    protected static function booted(): void
    {
        // Event 'deleting': Dijalankan TEPAT SEBELUM data dihapus dari database
        static::deleting(function ($link) {

            // Cek apakah link ini punya file QR Code
            if ($link->qr_path) {
                // Cek apakah file fisiknya ada di storage public
                if (Storage::disk('public')->exists($link->qr_path)) {
                    // HAPUS FILENYA
                    Storage::disk('public')->delete($link->qr_path);
                }
            }
        });
    }
}
