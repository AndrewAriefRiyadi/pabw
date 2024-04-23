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
            $keranjang = Keranjang::where('id_user', $user->id)
                                    ->where('completed',0)->first();
            $produks = [];
            if ($keranjang) {
                $pivot = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)->get();
                foreach ($pivot as $item) {
                    // Mengambil id_produk dan jumlah dari pivot
                    $id_produk = $item->id_produk;
                    $jumlah = $item->jumlah;

                    // Mendapatkan data produk berdasarkan id_produk
                    $produk = Produk::find($id_produk);

                    if ($produk) {
                        // Menambahkan data produk beserta jumlahnya ke dalam array $produks
                        $produks[] = (object)[
                            'produk' => $produk,
                            'jumlah' => $jumlah
                        ];
                    }
                }
            }
            // dd($keranjang->id);
            return view('keranjang.show', compact('produks','user','keranjang'));
        }else {
            return redirect('/')->withErrors(['message' => 'Gagal Membuka halaman']);
        }
    }

    public function delete_produk(Request $request, $username){
        try {
            $request->validate([
                'id_produk' => 'required'
            ]);
    
            $id_produk = $request->id_produk;
            $user = User::where('username', '=', $username)->firstOrFail();
            $keranjang = Keranjang::where('id_user', $user->id)
                                    ->where('completed',0)->firstOrFail();
            $harga_produk = Produk::where('id',$id_produk)->firstOrFail()->harga;
            $pivot = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)
                ->where('id_produk', $id_produk)->firstOrFail();
            $keranjang->harga_total -= $harga_produk * $pivot->jumlah;
            $keranjang->jumlah_total -= $pivot->jumlah;
            $keranjang->save();
            $pivot->delete();
    
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }   
    }

    public function kurang_produk(Request $request, $username){
        try {
            $request->validate([
                'id_produk' => 'required'
            ]);
    
            $id_produk = $request->id_produk;
            $user = User::where('username', '=', $username)->firstOrFail();
            $produk = Produk::where('id',$id_produk)->firstOrFail();
            $keranjang = Keranjang::where('id_user', $user->id)
                                    ->where('completed',0)->firstOrFail();
            $pivot = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)
                ->where('id_produk', $id_produk)->firstOrFail();
            if ($pivot->jumlah > 1) {
                $pivot->jumlah -= 1;
                $pivot->save();

                $keranjang->harga_total -= $produk->harga;
                $keranjang->jumlah_total -= 1;
                $keranjang->save();
                return redirect()->back()->with('success', 'Produk berhasil dikurangi.');
            } else {
                throw new \Exception('Jumlah produk sudah satu, tidak bisa dikurangi lagi.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }   
    }

    public function tambah_produk(Request $request, $username){
        try {
            $request->validate([
                'id_produk' => 'required'
            ]);
    
            $id_produk = $request->id_produk;
            $user = User::where('username', '=', $username)->firstOrFail();
            $produk = Produk::where('id',$id_produk)->firstOrFail();
            $keranjang = Keranjang::where('id_user', $user->id)
                                    ->where('completed',0)->firstOrFail();
            $pivot = PV_Keranjang_Produk::where('id_keranjang', $keranjang->id)
                ->where('id_produk', $id_produk)->firstOrFail();
            if ($pivot->jumlah + 1 <=  $produk->stok) {
                $pivot->jumlah += 1;
                $pivot->save();

                $keranjang->harga_total += $produk->harga;
                $keranjang->jumlah_total += 1;
                $keranjang->save();

                return redirect()->back()->with('success', 'Produk berhasil ditambah.');
            } else {
                throw new \Exception('Jumlah produk tidak bisa melebihi stok');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }   
    }
    
    public function store(Request $request) {
        try {
            $request->validate([
                'id_produk' => 'required',
                'jumlah' => 'required'
            ]);
            
            $id_produk = $request->input('id_produk');
            $produk = Produk::where('id',$id_produk)->firstOrFail();
            $jumlah = $request->input('jumlah');
            if ($jumlah > $produk->stok) {
                throw new \Exception('Jumlah produk tidak bisa melebihi stok');
            }else{
                $keranjang = $this->getOrCreateKeranjang();
                $this->addOrUpdateProduk($keranjang, $id_produk, $jumlah);
                return redirect()->back()->with('success', 'Barang berhasil ditambahkan');
            }
            
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        $produk = Produk::where('id', $id_produk)->firstOrFail();
    
        if (!$pivot) {
            $pivot = new PV_Keranjang_Produk();
            $pivot->id_keranjang = $keranjang->id;
            $pivot->id_produk = $id_produk;
            $pivot->jumlah = $jumlah;
            $pivot->status_kurir = "Keranjang";
            $pivot->save();
        } else {
            $pivot->jumlah += $jumlah;
            if ($pivot->jumlah > $produk->stok){
                throw new \Exception('Produk sudah ada di keranjang & jumlah produk tidak bisa melebihi stok');
            }
            $pivot->save();
        }
        $keranjang->jumlah_total += $jumlah;
        $keranjang->harga_total += $produk->harga * $jumlah;
        $keranjang->save();
    }
    
}

