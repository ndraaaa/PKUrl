<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $table = 'elink_advertisements';

    protected $fillable = ['title', 'target_url', 'image_path', 'is_active'];
}
