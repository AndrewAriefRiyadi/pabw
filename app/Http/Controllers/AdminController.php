<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $users = User::all();
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
}
