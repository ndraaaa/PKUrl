<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Link extends Model
{
    protected $table = 'links';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'page_id',
        'title',
        'destination_url',
        'short_code',
        'type',
        'order',
        'settings',
        'is_active',
        'expires_at',
        'click_count',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
        'click_count' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function analytics()
    {
        return $this->hasMany(Analytics::class);
    }

    // --- HELPER LOGIC ---

    /**
     * Cek apakah link valid untuk diakses?
     * Syarat: Status Active TRUE -DAN- Belum Expired
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && Carbon::now()->greaterThan($this->expires_at)) {
            return false;
        }

        return true;
    }

    public function isGuestLink(): bool
    {
        return is_null($this->user_id);
    }
}
