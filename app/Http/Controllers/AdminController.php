<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $users = User::latest()->get();
        $logs = Logs::latest()->get();
        return view('admin.dashboard', compact('users','logs'));
    }

    public function updateSaldo(Request $request){
        try{
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'saldo' => 'required|numeric|min:0',
            ]);

            $user = User::where('username',$validatedData['username'])->firstOrFail();
            $old_saldo = $user->saldo;
            $user->saldo = $validatedData['saldo'];
            $user->save();

            Logs::create(['deskripsi'=>'Admin berhasil merubah saldo '.$user->username.' dari '.$old_saldo.' menjadi sebanyak '.$user->saldo]);
            return redirect()->back()->with('success', 'Berhasil merubah saldo ' . $user->username);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update_produk(Request $request, $username, $id_produk){
        if ($username == Auth::user()->username) {
            try {
                $produk = Produk::find($id_produk);
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
                if ($validatedData['stok'] > 0) {
                    $validatedData['status_stok'] = 1;
                }else{
                    $validatedData['status_stok'] = 0;
                }
                $produk->update($validatedData);
                return redirect()->route('produk.show_produk', ['username' => $username, 'id' => $id_produk])->with('success', 'Produk berhasil di-edit!');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
            
        }else{
            return redirect()->back()->with('error', 'Anda tidak mempunyai akses.');
        }
    }
}
