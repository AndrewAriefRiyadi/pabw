<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\VL_Status_Barang;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Logs;
use App\Models\PV_Keranjang_Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function get_list_status($id_status){
        $list_status = [];
        if($id_status == 1){
            $list_status[0]= VL_Status_Barang::where('id',2)->first();
        };
        if($id_status == 2){
            $list_status[0]= VL_Status_Barang::where('id',3)->first();
        };
        return $list_status;
    }

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
                    $item->id_status = 1;
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
                            'id_pivot' => $item->id,
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

    public function show_toko($username){
        if (Auth::user()->username == $username) {
            try{
                $keranjangProduks = [];
                $keranjangUsers = [];
        
                $keranjangs_all = Keranjang::all();
                $keranjangs = [];
        
                foreach ($keranjangs_all as $keranjang) {
                    $pivot = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)->get();
                    $produks = []; // Inisialisasi array produk untuk setiap keranjang
                    $pembeli = User::find($keranjang->id_user);
                    if ($pembeli) {
                        $pembeli_object = (object)[
                            'name' => $pembeli->name,
                            'alamat' => $pembeli->alamat,
                        ];
                        foreach ($pivot as $item) {
                            $status = $item->status;
                            $list_status = $this->get_list_status($status->id);
                                $produk = Produk::find($item->id_produk);
                                if ($produk) {
                                    $penjual = User::find($produk->id_user);
                                    if ($penjual->username == $username) {
                                        $penjual_object = (object)[
                                            'name' => $penjual->name,
                                            'alamat' => $penjual->alamat
                                        ];
                                        $produks[] = (object)[
                                            'id_pivot' => $item->id,
                                            'produk' => $produk,
                                            'penjual' => $penjual_object,
                                            'jumlah' => $item->jumlah,
                                            'status_kurir' => $status,
                                            'list_status' => $list_status,
                                        ];
                                        $keranjangs[$keranjang->id] = $keranjang;
                                        
                                    }
                                }
                        }
                        $keranjangProduks[$keranjang->id] = $produks;
                        $keranjangUsers[$keranjang->id] = $pembeli_object;
                    }
                }
                return view('pesanan.show_toko', compact('keranjangProduks','keranjangUsers','keranjangs'));
            } catch  (\Throwable $e){
                return view('/')->with('error', $e->getMessage());
            }
        } else {
            return redirect('/')->withErrors(['message' => 'Gagal Membuka halaman']);
        }
    }

    public function diterima(Request $request, $username){
        try {
            $validatedData = $request->validate([
                'id_pivot' => 'required',
            ]);
            $id_pivot = $validatedData['id_pivot'];
            $pivot = PV_Keranjang_Produk::find($id_pivot);
            $produk = Produk::find($pivot->id_produk);
            $penjual = User::find($produk->id_user);
            $harga_total = $produk->harga * $pivot->jumlah;

            $penjual->saldo += $harga_total;
            $penjual->save();

            $pivot->id_status = 7;
            $pivot->save();

            $logs = ['deskripsi' => 'Pesanan dengan id_pivot ('.$id_pivot.') berhasil diterima. Penjual dengan username (' . $penjual->username . ') menerima saldo sebesar '.$harga_total];
            Logs::create($logs);
            return redirect()->back()->with('success', 'Pesanan Telah Diterima');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
