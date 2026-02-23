<?php

namespace App\Models;

// [Metode 5: Model] — User mewarisi Authenticatable dari Laravel
// Ini yang membuat Auth::attempt(), Auth::user(), Auth::check() bisa bekerja
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * [Metode 5: $fillable] — daftar kolom yang boleh diisi via User::create()
     * Tanpa ini, User::create([...]) akan error "mass assignment" protection.
     * Kolom yang ada di sini harus sesuai dengan kolom di migrasi (Metode 4).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',       // dari input: nama_lengkap
        'email',      // dari input: email
        'password',   // dari input: password (auto-hash via cast di bawah)
        'role',       // diset otomatis: 'tenant' saat register
        'nim',        // belum dipakai di register, tapi bisa ditambahkan nanti
        'prodi',      // belum dipakai di register
        'fakultas',   // belum dipakai di register
        'no_hp',      // dari input: nomor_telepon
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
     * [Metode 5: Casts] — 'password' => 'hashed' membuat Laravel otomatis
     * menjalankan Hash::make() setiap kali $user->password = 'plain_text' di-assign.
     * Ini yang membuat User::create(['password' => $request->password]) aman,
     * karena password disimpan ke DB sebagai bcrypt hash ($2y$12$...), bukan plain text.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',   // [Metode 3 & 5: Password Hashing] — auto bcrypt
        ];
    }

    /**
     * [Metode 2: Auth Facade helper] — dipakai oleh SuperadminMiddleware & AuthController
     * untuk mengecek apakah user ini admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }
}
