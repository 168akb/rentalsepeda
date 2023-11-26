<?php

namespace App\Http\Controllers;

use File;
use App\Product;
use App\HistoryProduct;
use App\sepeda_kategori;
use App\Merek;
use App\User;
use App\Transcation;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
   public function index(){

        $products = Product::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->where('lost', 0)
                    ->orderBy('status','desc')
                    ->paginate(8);
        $product = Product::all();
        $detail = Transcation::select('transcations.invoices_number','product_transation.product_id','transcations.user_id')
                                ->join('product_transation','product_transation.invoices_number','=','transcations.invoices_number')
                                ->join('products', 'products.id','=','product_transation.product_id')
                                ->join('users','users.id','=','transcations.user_id')
                                ->where('transcations.status','=','Sedang Dipinjam')
                                ->get();

        foreach ($detail as $key => $dt) {
            $namapeminjam = User::where('id', $dt->user_id)->first();  
        }

        return view('product.index', compact('products', 'namapeminjam'));
        }

    public function show(){
        $products = Product::onlyTrashed()->get();
        return view('product.bin', compact('products'));
    }

    public function restore($id){
        $products = Product::onlyTrashed()->where('id', $id);
        $product = Product::find($id);
        $products->restore();

        return redirect()->route('products.index')->with('success','Product berhasil di-restore');
    }


    public function restore_sepeda(){
        $products = Product::whereNotNull('kondisi')->get();

        return view('product.restore_sepeda', compact('products'));
    }

    public function cleardamage(Request $request, $id){
        $product_id = Product::find($id);
        $product = [
                        'kondisi' => null,
                    ];

        $product_id->update($product);
                
        $message = 'Product berhasil diperbaiki';

         return redirect()->route('products.index')->with('success',$message);
    }

    public function hilang(){
        $products = Product::where('lost', 1)->get();

        return view('product.hilang', compact('products'));
    }

    public function tandaihilang(Request $request, $id){
        $product_id = Product::find($id);
        $product = [
                        'lost' => 1,
                    ];

        $product_id->update($product);
                
        $message = 'Berhasil input kondisi sepeda';

        return Redirect::to(url()->previous());
    }

    public function tidakhilang(Request $request, $id){
        $product_id = Product::find($id);
        $product = [
                        'lost' => 0,
                    ];

        $product_id->update($product);
                
        $message = 'Product berhasil dikembalikan';

         return redirect()->route('products.index')->with('success',$message);
    }

    public function inputkondisi($id){
        $product = Product::find($id);

        return view('product.inputkondisi', compact('product'));
    }

    public function damage(Request $request, $id){
        $product_id = Product::find($id);
        $product = [
                        'kondisi' => $request->kondisi,
                    ];

        $product_id->update($product);
                
        $message = 'Berhasil input kondisi sepeda';

        return Redirect::to(url()->previous());
    }

    public function create(){
        $sepeda_kategori = sepeda_kategori::all();
        $merek = Merek::all();

        return view('product.create', compact('sepeda_kategori', 'merek'));
    }

    public function edit($id){
        
        $product = Product::find($id);

        if($product->status == 0){

        $sepeda_kategori = sepeda_kategori::all();
        $merek = Merek::all();
        $members = User::all();

        $detail = Transcation::select('transcations.invoices_number','product_transation.product_id','transcations.user_id')
                                ->join('product_transation','product_transation.invoices_number','=','transcations.invoices_number')
                                ->join('products', 'products.id','=','product_transation.product_id')
                                ->join('users','users.id','=','transcations.user_id')
                                ->where('products.id', $id)
                                ->where('transcations.status','=','Sedang Dipinjam')
                                ->get();

        foreach ($detail as $key => $dt) {
            $namapeminjam = User::where('id', $dt->user_id)->first();  
        }
        // dd($namapeminjam);
    } else {
        $sepeda_kategori = sepeda_kategori::all();
        $merek = Merek::all();
        $members = User::all();
        $namapeminjam = Transcation::select('transcations.invoices_number','product_transation.product_id','transcations.user_id')
                                ->join('product_transation','product_transation.invoices_number','=','transcations.invoices_number')
                                ->join('products', 'products.id','=','product_transation.product_id')
                                ->join('users','users.id','=','transcations.user_id')
                                ->where('products.id', $id)
                                ->where('transcations.status','=','Sedang Dipinjam')
                                ->get();
    }

        return view('product.edit', compact('product', 'sepeda_kategori', 'merek', 'namapeminjam', 'members'));
    }

    public function destroy(Request $request, $id){

        $product = Product::find($id);
        $name = Product::where('name', $id);
        $product->delete();

        return redirect()->route('products.index')->with('success','Sepeda ID : '.$id.' berhasil dihapus');                             
        }   

    public function store(Request $request){       

        DB::beginTransaction();

        try{
            $id = $request->id;

            if($id){ #Update Data
                $this->validate($request, [
                    'name' => 'required|min:2|max:200',
                    'price' => 'required',
                    'description' => 'required',
                ]);


                $product_id = Product::find($id);
                if($request->has('image')){
                    $gambar = $request->image;
                    $new_gambar = time().$gambar->getClientOriginalName();
                    Image::make($gambar->getRealPath())->resize(null, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('uploads/images/' . $new_gambar));

                    File::delete(public_path($product_id->image));

                    $p = $request->price;
                    $fine_price = 0.75 * $p;
                    
                    $product = [
                        'name' => $request->name,
                        'price' => $request->price,
                        'fine_price' => $p - $fine_price,      
                        'image' => 'uploads/images/'.$new_gambar,
                        'description' => $request->description,
                        'sepeda_kategori_id' => $request->sepeda_kategori_id,
                        'merek_id' => $request->merek_id,

                    ];
                }
                else{

                    $p = $request->price;
                    $fine_price = 0.75 * $p;

                    $product = [
                        'name' => $request->name,
                        'price' => $request->price,    
                        'fine_price' => $p - $fine_price,                         
                        'description' => $request->description,
                        'sepeda_kategori_id' => $request->sepeda_kategori_id,
                        'merek_id' => $request->merek_id,

                    ];
                }

                $product_id->update($product);
                
                $message = 'Data Berhasil di update';

                DB::commit();
                return redirect()->route('products.index')->with('success',$message);   
            }else{ # Create Data
                $this->validate($request, [
                    'name' => 'required|min:2|max:200',
                    'price' => 'required',
                    'image' => 'mimes:jpeg,jpg,png,gif|required|max:25000',
                    'description' => 'required',
                    'sepeda_kategori_id' => 'required',
                    'merek_id' => 'required'
                ]);

                $gambar = $request->image;
                $new_gambar = time().$gambar->getClientOriginalName();

                $product = Product::create([
                        'name' => $request->name,
                        'price' => $request->price,
                        'sepeda_kategori_id' => $request->sepeda_kategori_id,              
                        'image' => 'uploads/images/'.$new_gambar,
                        'description' => $request->description,
                        'user_id' => Auth::id(),
                        'merek_id' => $request->merek_id,
                        'status' => 1
                ]);        

                Image::make($gambar->getRealPath())->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/images/' . $new_gambar));

                $message = 'Data Berhasil di simpan';

                DB::commit();
                return redirect()->route('products.index')->with('success',$message);   
            }            
        }
        catch(\Exeception $e){
            DB::rollback();
            return redirect()->route('products.create')->with('error',$e);
        }         
    }
        
}


