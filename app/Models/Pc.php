<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pc extends Model
{
    protected $fillable = [
        'user_id',
        'kode_pc',
        'nama_pc',
        'kategori',
        'prosesor',
        'vga',
        'ram',
        'storage',
        'motherboard',
        'psu',
        'casing',
        'harga',
        'stok',
        'tersedia',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'tersedia' => 'boolean',
        'harga' => 'decimal:2',
    ];

    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true);
    }
}
