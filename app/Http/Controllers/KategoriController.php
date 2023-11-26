<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sepeda_kategori;

class KategoriController extends Controller
{
    public function index(){

        $kategori = sepeda_kategori::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->orderBy('name','asc')
                    ->paginate(8);
        return view('kategori.index', compact('kategori'));
    }

    public function create(){
    	return view('kategori.create');
    }

    public function store(Request $request){       
		$merek = new sepeda_kategori;
		$merek->name = $request->name;

		$merek->save();
		return redirect()->route('kategori.index')->with('success','Kategori berhasil ditambahkan');  
    }

    public function destroy(Request $request, $id){

        $merek = sepeda_kategori::find($id);
        $merek->delete();

        return redirect()->Route('kategori.index')->with('success','Kategori berhasil dihapus');                             
        }
}
