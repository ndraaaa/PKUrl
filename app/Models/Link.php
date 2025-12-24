<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'original_url',
        'short_code',
        'type',
        'click_count',
        'is_active',
    ];

    // Relasi: Link ini milik User siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
