<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'handle',
        'title',
        'bio',
        'avatar_path',
        'appearance',
        'meta_title',
        'meta_description',
        'is_public',
    ];

    /**
     * Casting otomatis:
     * - 'appearance' di DB (JSON) -> jadi Array di PHP
     * - 'is_public' di DB (0/1) -> jadi Boolean (true/false) di PHP
     */
    protected $casts = [
        'appearance' => 'array',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class)->orderBy('order', 'asc');
    }
}
