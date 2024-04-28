<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\PV_Keranjang_Produk;
use Illuminate\Support\Facades\Auth;
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
            if ($pivots->isEmpty()){
                throw new \Exception('Anda tidak memesan produk apapun.');
            }else{
                $user = User::where('username','=',$username)->first();
                if ($user->saldo < $keranjang->harga_total){
                    throw new \Exception('Saldo anda tidak mencukupi');
                }else{
                    $user->saldo -= $keranjang->harga_total;
                    $user->save();
                }
                foreach ($pivots as $item) {
                    // Mengambil id_produk dan jumlah dari pivot
                    $id_produk = $item->id_produk;
                    $jumlah = $item->jumlah;
                    $item->id_status = 3;
                    $item->save();
                    // Mendapatkan data produk berdasarkan id_produk
                    $produk = Produk::find($id_produk);
                    if ($produk) {
                        // Mengurangi stok produk 
                        $produk->stok -= $jumlah;
                        if ($produk->stok <= 0){
                            $produk->status_stok = 0;
                        }
                        $produk->save();
                    }
                }
                $keranjang->completed = true;
                $keranjang->save();
                $validatedData['status_pembayaran'] = false;
                $validatedData['tanggal'] = Carbon::now();
                Pesanan::create($validatedData);
                return redirect()->back()->with('success', 'Pesanan Berhasil dibuat');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($username){
        if (Auth::user()->username == $username) {
            $user = User::where('username','=',$username)->first();
            $keranjangs = Keranjang::where('id_user', $user->id)
                                    ->where('completed',1)->get();
            $keranjangProduks = [];
            foreach ($keranjangs as $keranjang) {
                $pivot = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)->get();
                $produks = []; // Inisialisasi array produk untuk setiap keranjang
                foreach ($pivot as $item) {
                    // Mengambil id_produk dan jumlah dari pivot
                    $id_produk = $item->id_produk;
                    $jumlah = $item->jumlah;
                    $status = $item->status;
                    // Mendapatkan data produk berdasarkan id_produk
                    $produk = Produk::find($id_produk);
                    if ($produk) {
                        // Menambahkan data produk beserta jumlahnya ke dalam array $produks
                        $produks[] = (object)[
                            'produk' => $produk,
                            'jumlah' => $jumlah,
                            'status'=>$status
                        ];
                    }
                }
                // Menyimpan array produk ke dalam array asosiatif dengan kunci keranjang
                $keranjangProduks[$keranjang->id] = $produks;
            }
            return view('pesanan.show', compact('keranjangProduks','user','keranjangs'));
        } else {
            return redirect('/')->withErrors(['message' => 'Gagal Membuka halaman']);
        }
    }
}
