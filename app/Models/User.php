<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'profile', // Pastikan di controller pakai 'profile' juga (bukan avatar)
        'theme',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI DATA ---

    // 1. User punya banyak Halaman (Bio Page)
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    // 2. User punya link yang ada DI DALAM halaman (Has Many Through)
    public function links()
    {
        return $this->hasManyThrough(Link::class, Page::class);
    }

    // 3. [BARU] Link Global (Shortlink Murni yang tidak masuk Page)
    // Relasi langsung ke tabel links, tapi difilter yang page_id-nya NULL
    public function globalLinks()
    {
        return $this->hasMany(Link::class)->whereNull('page_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // SKENARIO 1: Saat user dihapus (Delete Account)
        static::deleting(function ($user) {
            // Hapus file profile jika ada
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }
        });

        // SKENARIO 2: Saat user mengganti foto (Update Profile)
        static::updating(function ($user) {
            // Cek apakah kolom 'profile' berubah (diganti gambar baru)
            if ($user->isDirty('profile')) {
                // Ambil nama file profile YANG LAMA
                $oldProfile = $user->getOriginal('profile');

                // Jika dulu punya profile, hapus file lama tersebut
                if ($oldProfile && Storage::disk('public')->exists($oldProfile)) {
                    Storage::disk('public')->delete($oldProfile);
                }
            }
        });
    }
}
