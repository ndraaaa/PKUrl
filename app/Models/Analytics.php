<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database. 
     * Laravel otomatis menganggap 'analytics', tapi kita tulis eksplisit biar jelas.
     */
    protected $table = 'analytics';

    protected $fillable = [
        'link_id',
        'ip_address',
        'country_code',
        'city',
        'device',
        'browser',
        'os',
        'referer',
    ];

    // --- RELASI ---

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    // --- SCOPE (Helper Query) ---
    // Ini berguna buat bikin Grafik di Dashboard nanti biar kodingan Controller bersih.

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}