<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logs()
    {
        $logs = Logs::all();
        return view('admin.logs', compact('logs'));
    }
    public function users()
    {
        $users = User::withTrashed()->get();
        return view('admin.users', compact('users'));
    }
    public function create_user()
    {
        return view('admin.create_user');
    }
    public function insert_user(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'email' => 'required|string|max:1024',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|min:0',
                'role' => 'required|string',
            ]);
            $user = User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'alamat' => $validatedData['alamat'],
                'no_hp' => $validatedData['no_hp'],
                'saldo' => 0,
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            $user->assignRole($validatedData['role']);
            $logs['deskripsi'] = Auth::user()->username . ' telah membuat user dengan username' . $user->username;
            Logs::create($logs);
            return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error', $th->getMessage()]);
        }
    }
    public function edit_user($id)
    {
        $user = User::withTrashed()->find($id);
        return view('admin.edit_user', compact('user'));
    }
    public function update_user(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'email' => 'required|string|max:1024',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|min:0',
                'role' => 'required|string',
            ]);
            $user = User::withTrashed()->find($id);
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            $user->alamat = $validatedData['alamat'];
            $user->no_hp = $validatedData['no_hp'];
            $user->save();

            $user->syncRoles([]);
            $user->assignRole($validatedData['role']);

            $logs['deskripsi'] = Auth::user()->username . ' telah update user dengan username ' . $user->username;
            Logs::create($logs);
            return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error', $th->getMessage()]);
        }
    }

    public function suspend_user($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            Logs::create(['deskripsi' => 'Admin suspend akun dengan username ' . $user->username]);
            return redirect()->back()->with('success', 'User suspended successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function restore_user($id)
    {
        try {
            // Mengambil pengguna yang dihapus termasuk soft deleted
            $user = User::withTrashed()->find($id);
            if ($user && $user->trashed()) {
                // Mengaktifkan kembali pengguna yang dihapus
                $user->restore();
                Logs::create(['deskripsi' => 'Admin resotre akun dengan username ' . $user->username]);
                return redirect()->back()->with('success', 'User restored successfully.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function produks()
    {
        $produks = Produk::all();
        return view('admin.produks', compact('produks'));
    }

    public function create_produk()
    {
        $users = User::all();
        return view('admin.create_produk', compact('users'));
    }

    public function store_produk(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_user' => 'required|numeric|max:255',
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
                'foto' => 'image|file|max:1024',
                'deskripsi' => 'required|string',
                'stok' => 'required|integer|min:0',
            ]);
            // Simpan produk ke database
            if ($request->file('foto')) {
                $validatedData['foto'] = $request->file('foto')->store('foto-produks');
            }

            if ($validatedData['stok'] >= 1) {
                $validatedData['status_stok'] = 1;
            } else {
                $validatedData['status_stok'] = 0;
            }

            $new_product = Produk::create($validatedData);
            $logs['deskripsi'] = Auth::user()->username . ' telah membuat produk dengan id ' . $new_product->id;
            Logs::create($logs);
            return redirect()->route('admin.produks')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit_produk($id)
    {
        $users = User::all();
        $produk = Produk::find($id);
        return view('admin.edit_produk', compact('users', 'produk'));
    }

    public function update_produk(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_user' => 'required|numeric|max:255',
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
                'foto' => 'image|file|max:1024',
                'deskripsi' => 'required|string',
                'stok' => 'required|integer|min:0',
            ]);
            // Simpan produk ke database
            if ($request->file('foto')) {
                $validatedData['foto'] = $request->file('foto')->store('foto-produks');
            }

            if ($validatedData['stok'] >= 1) {
                $validatedData['status_stok'] = 1;
            } else {
                $validatedData['status_stok'] = 0;
            }
            $produk = Produk::find($id);
            $produk->update($validatedData);
            $logs['deskripsi'] = Auth::user()->username . ' telah meng-update produk dengan id ' . $produk->id;
            Logs::create($logs);
            return redirect()->route('admin.produks')->with('success', 'Produk berhasil diupdate!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete_produk($id){
        try {
            $produk = Produk::find($id);
            $produk->delete();
            $logs['deskripsi'] = Auth::user()->username . ' telah delete produk dengan id ' . $produk->id;
            Logs::create($logs);
            return redirect()->route('admin.produks')->with('success', 'Produk berhasil didelete!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function updateSaldo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'saldo' => 'required|numeric|min:0',
            ]);

            $user = User::where('username', $validatedData['username'])->firstOrFail();
            $old_saldo = $user->saldo;
            $user->saldo = $validatedData['saldo'];
            $user->save();
            Logs::create(['deskripsi' => 'Admin berhasil merubah saldo ' . $user->username . ' dari ' . $old_saldo . ' menjadi sebanyak ' . $user->saldo]);
            return redirect()->back()->with('success', 'Berhasil merubah saldo ' . $user->username);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
