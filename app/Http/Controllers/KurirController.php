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

class KurirController extends Controller
{
    public function show_barang(){
        try{
            $keranjangs = Keranjang::all();
            foreach ($keranjangs as $keranjang) {
                $pivot = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)->get();
                $produks = []; // Inisialisasi array produk untuk setiap keranjang'
                $pembeli = User::where('id',$keranjang->id_user)->first();
                $pembeli_object = (object)[
                    'name' => $pembeli->name,
                    'alamat' => $pembeli->alamat,
                ];
                foreach ($pivot as $item) {
                    $id_produk = $item->id_produk;
                    $jumlah = $item->jumlah;
                    $status_kurir = $item->status_kurir;
                    if($status_kurir == 'Menunggu Kurir'){
                        // Mendapatkan data produk berdasarkan id_produk
                        $produk = Produk::find($id_produk);
                        if ($produk) {
                            // Menambahkan data produk beserta jumlahnya ke dalam array $produks
                            $penjual = User::where('id',$produk->id_user)->first();
                            $penjual_object = (object)[
                                'name' => $penjual->name,
                                'alamat' => $penjual->alamat
                            ];
                            $produks[] = (object)[
                                'produk' => $produk,
                                'penjual' => $penjual_object,
                                'jumlah' => $jumlah,
                                'status_kurir'=>$status_kurir
                            ];
                        }
                        
                        // Menyimpan array produk ke dalam array asosiatif dengan kunci keranjang
                        $keranjangProduks[$keranjang->id] = $produks;
                        $keranjangUsers[$keranjang->id] = $pembeli_object;
                    }
                    else {
                        throw new \Exception('Anda tidak memesan produk apapun.');
                    }
                }   
            }
            return view('kurir.show_barang', compact('keranjangProduks','keranjangUsers','keranjangs',));
        } catch  (\Throwable $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
}

