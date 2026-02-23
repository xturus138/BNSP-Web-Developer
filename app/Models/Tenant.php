<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function anggotaTims()
    {
        return $this->hasMany(AnggotaTim::class);
    }
}
