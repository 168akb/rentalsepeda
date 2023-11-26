<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Image;
use File;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{

    public function index(){
    	return view('profile.index', array('user' => Auth::user()));
    }

    public function edit(){
    	return view('profile.edit', array('user' => Auth::user()));
        // return view('profile.edit')->with('user', auth()->user());
    }

    public function update(Request $request){
        // print_r($request->all());
    if($request->has('pfp')){

            $image = $request->file('pfp');
            $new_gambar = time().'-'.Auth::user()->name.'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(null, 750)->save(public_path('uploads/pfp/' . $new_gambar));
            

            $user = Auth::user();
            File::delete(public_path($user->pfp));
            $user->pfp = 'uploads/pfp/'. $new_gambar;
            $user->name = $request->name;
            $user->lembaga = $request->lembaga;
            $user->telepon = $request->telepon;
            $user->kota = $request->kota;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->save();

    }else{
        $user = Auth::user();
            $user->name = $request->name;
            $user->lembaga = $request->lembaga;
            $user->telepon = $request->telepon;
            $user->kota = $request->kota;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->save();
    }
        $message = 'Berhasil update informasi pengguna';
        return redirect()->route('profile.index')->with('success', $message);  
    }


    public function uploadktp(Request $request) {
            $image = $request->file('foto_ktp');
            $new_gambar = time().'-'.'KTP'.'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(null, 400, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('uploads/foto_ktp/' . $new_gambar));

            $user = Auth::user();
            File::delete(public_path($user->foto_ktp));
            $user->foto_ktp = 'uploads/foto_ktp/'.$new_gambar;
            $user->save();

            $message = 'Berhasil upload KTP pengguna';
            return redirect()->route('profile.index')->with('success', $message);  
    }

    public function viewktp(){
        return view('profile.uploadktp', array('user' => Auth::user()));
        // return view('profile.edit')->with('user', auth()->user());
    }
}
