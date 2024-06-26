<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PV_Keranjang_Produk extends Model
{
    use HasFactory;
    protected $table = 'pv_keranjang_produks';
    protected $fillable = [
        'id_keranjang',
        'id_produk',
        'jumlah',
        'id_status'
    ];
    // Di model yang memiliki foreign key
    public function status()
    {
        return $this->belongsTo(VL_Status_Barang::class, 'id_status');
    }
    
}
