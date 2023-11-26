<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merek;

use Illuminate\Support\Facades\DB;

class MerekController extends Controller
{
    public function index(){

        $merek = Merek::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->orderBy('name','asc')
                    ->paginate(8);
        return view('merek.index', compact('merek'));
    }

    public function create(){
    	return view('merek.create');
    }

    public function store(Request $request){       
		$merek = new Merek;
		$merek->name = $request->name;

		$merek->save();
		return redirect()->route('mereks.index')->with('success','Merek berhasil ditambahkan');  
    }

    public function destroy(Request $request, $id){

        $merek = Merek::find($id);
        $merek->delete();

        return redirect()->Route('mereks.index')->with('success','Merek berhasil dihapus');                             
        }


}
