<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'harga' => 'double',
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
