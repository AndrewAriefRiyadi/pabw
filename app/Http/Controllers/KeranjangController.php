<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\PV_Keranjang_Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Keranjang;

class KeranjangController extends Controller
{
    public function show($username){
        if (Auth::user()->username == $username) {
            $user = User::where('username','=',$username)->get()->first();
            $produks = Produk::where('id_user', '=', $user->id)->get();
            return view('keranjang.show', compact('produks','user'));
        }else {
            return redirect('/')->withErrors(['message' => 'Gagal Membuka halaman']);
        }
    }
    
    public function store(Request $request) {
        $request->validate([
            'id_produk' => 'required',
            'jumlah' => 'required'
        ]);
        
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');
        
        $keranjang = $this->getOrCreateKeranjang();
        $this->addOrUpdateProduk($keranjang, $id_produk, $jumlah);
        
        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
    }
    
    private function getOrCreateKeranjang() {
        $id_user = Auth::id();
        $keranjang = Keranjang::where('id_user', $id_user)
                    ->where('completed', false)
                    ->first();
    
        if (!$keranjang) {
            $keranjang = new Keranjang();
            $keranjang->id_user = $id_user;
            $keranjang->jumlah_total = 0;
            $keranjang->harga_total = 0;
            $keranjang->completed = false;
            $keranjang->save();
        }
    
        return $keranjang;
    }
    
    private function addOrUpdateProduk($keranjang, $id_produk, $jumlah) {
        $pivot = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)
                    ->where('id_produk', $id_produk)
                    ->first();
        $produk = Produk::where('id', $id_produk)->first();
    
        if (!$pivot) {
            $pivot = new PV_Keranjang_Produk();
            $pivot->id_keranjang = $keranjang->id;
            $pivot->id_produk = $id_produk;
            $pivot->jumlah = $jumlah;
            $pivot->status_kurir = "Keranjang";
            $pivot->save();
        } else {
            $pivot->jumlah += $jumlah;
            $pivot->save();
        }
        $keranjang->jumlah_total += $jumlah;
        $keranjang->harga_total += $produk->harga;
        $keranjang->save();
    }
    
}

