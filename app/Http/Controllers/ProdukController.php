<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function show($id){
        $produks = Produk::where('id_user', '=', $id)->get();
        return view('produk.show', compact('produks'));
    }

    public function create(){
        return view('produk.create');
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
        Produk::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('produk.show', ['id' => Auth::id()])->with('success', 'Produk berhasil ditambahkan!');
    }
}
