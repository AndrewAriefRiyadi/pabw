<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VL_Status_Barang extends Model
{
    use HasFactory;
    protected $table = 'vl_status_barang';
    protected $fillable = [
        'status'
    ];
}
