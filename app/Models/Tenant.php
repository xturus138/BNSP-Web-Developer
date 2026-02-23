<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

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

    /**
     * Scope: Search by business name, leader name, or NIM.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_tenant', 'like', "%{$keyword}%")
                ->orWhereHas('anggotaTims', function ($aq) use ($keyword) {
                    $aq->where('nama_anggota', 'like', "%{$keyword}%")
                        ->orWhere('nim', 'like', "%{$keyword}%");
                });
        });
    }

    /**
     * Scope: Filter by registration date range.
     */
    public function scopeDateRange(Builder $query, ?string $from, ?string $to): Builder
    {
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        return $query;
    }

    /**
     * Scope: Filter by latest proposal status.
     */
    public function scopeByStatus(Builder $query, ?string $status): Builder
    {
        if (! $status) {
            return $query;
        }

        return $query->whereHas('proposals', function ($q) use ($status) {
            $q->where('status', $status);
        });
    }

    /**
     * Accessor: Get latest proposal.
     */
    public function getLatestProposalAttribute()
    {
        return $this->proposals->sortByDesc('created_at')->first();
    }

    /**
     * Accessor: Get team leader (first member).
     */
    public function getKetuaAttribute()
    {
        return $this->anggotaTims->first();
    }
}
