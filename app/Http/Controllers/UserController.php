<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit($id){
        if (Auth::user()->hasRole('admin') or Auth::user()->id == $id) {
            $user = User::find($id);
            return view('user.edit',compact('user'));
        }else{
            return redirect()->back();
        }
    }

    public function update($id, Request $request){
        if (Auth::user()->hasRole('admin') or Auth::user()->id == $id) {
            try {
                $validatedData = $request->validate([
                    'name' => 'required|string',
                    'username' => 'required|string',
                    'email' => 'required|string',
                    'alamat' => 'required|string',
                    'no_hp' => 'required|numeric',
                ]);
                $user = User::find($id);
                $user->name = $validatedData['name'];
                $user->username = $validatedData['username'];
                $user->email = $validatedData['email'];
                $user->alamat = $validatedData['alamat'];
                $user->no_hp = $validatedData['no_hp'];
                $user->save();
                return redirect()->back()->with('success', 'Data berhasil diupdate');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
        }else{
            return redirect()->back();
        }
    }
}
