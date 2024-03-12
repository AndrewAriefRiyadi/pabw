<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'nama',
        'harga',
        'foto',
        'deskripsi',
        'stok',
        'status_stok',
    ];
}
