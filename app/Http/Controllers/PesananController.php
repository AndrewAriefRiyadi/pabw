<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\PV_Keranjang_Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function store(Request $request,$username) {
        try {
            $validatedData = $request->validate([
                'id_keranjang' => 'required',
            ]);
            
            $keranjang = Keranjang::where('id', $validatedData['id_keranjang'])->firstOrFail();
            $pivots = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)->get();
            foreach ($pivots as $item) {
                // Mengambil id_produk dan jumlah dari pivot
                $id_produk = $item->id_produk;
                $jumlah = $item->jumlah;

                // Mendapatkan data produk berdasarkan id_produk
                $produk = Produk::find($id_produk);

                if ($produk) {
                    // Mengurangi stok produk 
                    $produk->stok -= $jumlah;
                    $produk->save();
                }
            }
            if ($pivots->isEmpty()){
                throw new \Exception('Anda tidak memesan produk apapun.');
            }

            $keranjang->completed = true;
            $keranjang->save();
            $validatedData['status_pembayaran'] = false;
            $validatedData['tanggal'] = Carbon::now();
            Pesanan::create($validatedData);
            return redirect()->back()->with('success', 'Pesanan Berhasil dibuat');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }
}
