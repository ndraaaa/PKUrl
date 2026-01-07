<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'handle',
        'title',
        'bio',
        'avatar',
        'theme',
        'background_image',
    ];

    // Page milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Page punya banyak Link
    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
