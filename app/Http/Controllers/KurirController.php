<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\PV_Keranjang_Produk;
use App\Models\VL_Status_Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KurirController extends Controller
{
    public function get_list_status($id_status){
        $list_status = [];
        if($id_status == 3){
            $list_status[0]= VL_Status_Barang::where('id',4)->first();
            $list_status[1]= VL_Status_Barang::where('id',5)->first();
        };
        if($id_status == 4){
            $list_status[0]= VL_Status_Barang::where('id',6)->first();
        };
        if($id_status == 5){
            $list_status[0]= VL_Status_Barang::where('id',1)->first();
        }; 
        return $list_status;
    }

    public function show_barang(){
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
                        if($status->id == 3 || $status->id == 4 || $status->id == 5){
                            $keranjangs[$keranjang->id] = $keranjang;
                            $list_status = $this->get_list_status($status->id);
                            $produk = Produk::find($item->id_produk);
                            
                            if ($produk) {
                                $penjual = User::find($produk->id_user);
                                if ($penjual) {
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
                                }
                            }
                        } else {
                            continue 2; // Melanjutkan ke iterasi berikutnya pada loop foreach terluar
                        }
                    }
                    $keranjangProduks[$keranjang->id] = $produks;
                    $keranjangUsers[$keranjang->id] = $pembeli_object;
                }
            }
    
            return view('kurir.show_barang', compact('keranjangProduks','keranjangUsers','keranjangs'));
        } catch  (\Throwable $e){
            return view('kurir.show_barang')->with('error', $e->getMessage());
        }
    }
    

    public function update_status(Request $request){
        // Validasi input
        try {
            $validatedData = $request->validate([
                'id_pivot' => 'required|numeric|max:255',
                'id_status' => 'required|numeric|max:255',
            ]);
            $pivot = PV_Keranjang_Produk::where('id',$validatedData['id_pivot'])->first();
            $pivot->id_status = $validatedData['id_status'];
            $pivot->save();
            return redirect()->back()->with('success', 'Berhasil Meng-Update Status Barang');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }
}

