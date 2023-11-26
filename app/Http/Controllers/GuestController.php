<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class GuestController extends Controller
{
    public function index(){
    	$products = Product::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->orderBy('status','desc')
                    ->paginate(12);
        return view('guest.index', compact('products'));
    }
}
