<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;

class ProdukController extends Controller
{
    public function show($username){
        $user = User::where('username','=',$username)->get()->first();
        $produks = Produk::where('id_user', '=', $user->id)->get();
        return view('produk.show', compact('produks','user'));
    }

    public function create($username){
        if (Auth::user()->username == $username) {
            return view('produk.create');
        }else {
            return redirect('/')->withErrors(['message' => 'Gagal Membuka halaman']);
        }
        
    }

    public function store(Request $request)
    {
        
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'foto' => 'image|file|max:1024',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
        ]);
        // Simpan produk ke database
        if($request->file('foto')){
            $validatedData['foto'] = $request->file('foto')->store('foto-produks');
        }
        $validatedData['id_user'] = Auth::id();
        $validatedData['status_stok'] = 1;
        $new_product = Produk::create($validatedData);


        $logs['deskripsi'] =  Auth::user()->username . ' telah membuat produk dengan id ' .  $new_product->id;
        Logs::create($logs);
        // Redirect dengan pesan sukses
        return redirect()->route('produk.show', ['username' => Auth::user()->username])->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show_produk($username, $id){
        $user = User::where('username','=',$username)->get()->first();
        $produk = Produk::where('id', '=', $id)->get()->first();
        return view('produk.show_produk', compact('produk','user'));
    }
}
