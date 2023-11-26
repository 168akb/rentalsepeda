<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\HistoryProduct;
use App\ProductTranscation;
use Carbon\Carbon;

use App\Transcation;
use Auth;
use DB;

use Darryldecode\Cart\CartCondition;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\Facades\Image;


class TransactionController extends Controller
{
    public function index(){    
             
        //product
        $products = Product::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->where('lost', 0)
                    ->orderBy('status','desc')
                    ->paginate(12);

        $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'pajak',
                'type' => 'discount',
                'target' => 'total',
                'value' => 0,
                'order' => 1  
            ));                
            
        \Cart::session(Auth()->id())->condition($condition);          

        $items = \Cart::session(Auth()->id())->getContent();

        if(\Cart::isEmpty()){
            $cart_data = []; 
            $item = [];          
        }
        else{
            foreach($items as $row) {
                $cart[] = [
                    'rowId' => $row->id,
                    'brand' => $row->brand,
                    'name' => $row->name,
                    'qty' => $row->quantity,
                    'pricesingle' => $row->price,
                    'price' => $row->getPriceSum(),
                    'denda' => $row->denda,
                    'created_at' => $row->attributes['created_at'],
                ];           
            }
            $cart_data = collect($cart)->sortBy('created_at');
            
        }

        // dd($cart_data);

        $hitung = count($items);
        //total
        $sub_total = \Cart::session(Auth()->id())->getSubTotal();
        $total = \Cart::session(Auth()->id())->getTotal();
        
        if ($hitung >= 3) {
            $discount = ($total / 100) * 10;
        } else {
            $discount = 0;
        }
        // dd($total);
        $data_total = [
            'sub_total' => $sub_total,
            'total' => $total - $discount,
        ];
        // dd($data_total);
        return view('pos.index', compact('products','cart_data','data_total'));
    }

    public function addProductCart($id){
        $product = Product::find($id);      
        
        $cart = \Cart::session(Auth()->id())->getContent();        
        $cek_itemId = $cart->whereIn('id', $id);  
        // dd($cart);
        if($cek_itemId->isNotEmpty()){
        
        }else{
             \Cart::session(Auth()->id())->add(array(
            'id' => $id,
            'brand' => $product->merek->name,
            'name' => $product->name,
            'price' => $product->price,
            'denda' => $product->fine_price,
            'quantity' => 1, 
            'attributes' => array(
                'created_at' => date('Y-m-d H:i:s')
            )          
        ));
        
        }       

        return redirect()->back();
    }

    public function removeProductCart($id){
        \Cart::session(Auth()->id())->remove($id);     
                         
        return redirect()->back();
    }

    public function bayar(){

        $cart_total = \Cart::session(Auth()->id())->getTotal();
        $bayar = request()->totalHidden;
        $kembalian = (int)$bayar - (int)$cart_total;
        $atas_nama = request()->atas_nama;
        $tgl_sewa = request()->tgl_sewa;
        $tgl_kembali = request()->tgl_kembali;
        $metode_pembayaran = request()->metode;
        $harga_sewa = Carbon::parse($tgl_sewa)->diffInDays($tgl_kembali) * $bayar;
        $tgl_sekarang = Carbon::now();
        $expire = Carbon::now()->addMinute(1);
        $lusa = $tgl_sekarang->addDays(2);
        // $std = $str->toDateTimeString();
        // dd($std);
        
            DB::beginTransaction();

            try{

            $all_cart = \Cart::session(Auth()->id())->getContent();
           // dd($all_cart);

            $filterCart = $all_cart->map(function($item){
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity
                ];
            });
            
            foreach($filterCart as $cart){
                $product = Product::find($cart['id']);
                 if($product->status == 0){
                    notify()->error('Cek status ketersediaan sepeda!');
                    return redirect()->back();
                } elseif($tgl_sewa > $lusa){
                    notify()->error('Tanggal sewa tidak boleh lebih dari 2 hari dari hari sekarang!');
                    return redirect()->back();
                } elseif($tgl_sewa > $tgl_kembali) {
                    notify()->error('Tanggal peminjaman tidak valid!');
                    return redirect()->back();
                } else {
                    notify()->success('Transaksi berhasil dibuat!');
                    $product->status = 0;
                    $product->save();
                }
            }

                
                $id = IdGenerator::generate(['table' => 'transcations', 'length' => 10, 'prefix' =>'INV-', 'field' => 'invoices_number']);

                if($metode_pembayaran != 'Transfer'){

                Transcation::create([
                    'invoices_number' => $id,
                    'user_id' => Auth::id(),
                    'pay' => $harga_sewa,
                    'tgl_sewa' => $tgl_sewa,
                    'tgl_kembali' => $tgl_kembali,
                    'total' => $cart_total,
                    'bukti_pembayaran' => '-',
                    'metode_pembayaran' => $metode_pembayaran,
                    'status' => 'Menunggu Diambil'
                ]);

                }else{

                Transcation::create([
                    'invoices_number' => $id,
                    'user_id' => Auth::id(),
                    'pay' => $harga_sewa,
                    'tgl_sewa' => $tgl_sewa,
                    'tgl_kembali' => $tgl_kembali,
                    'total' => $cart_total,
                    'metode_pembayaran' => $metode_pembayaran,
                    'status' => 'Menunggu Pembayaran',
                    'expires' => $expire
                ]);

            }

            foreach($filterCart as $cart){    

                ProductTranscation::create([
                    'product_id' => $cart['id'],
                    'invoices_number' => $id,
                    'qty' => $cart['quantity'],
                ]);                
            }

            \Cart::session(Auth()->id())->clear();

            DB::commit();        
            return redirect()->back()->with('success','Transaksi Sukses | Klik History untuk print');        
            }catch(\Exeception $e){
            DB::rollback();
                return redirect()->back()->with('errorTransaksi','jumlah pembayaran gak valid');        
            }        
        }

    public function clear(){
        \Cart::session(Auth()->id())->clear();
        return redirect()->back();
    }

    public function history(){
        $history = Transcation::when(request('search'), function($query){
                        return $query->where('invoices_number','like','%'.request('search').'%');
                    })
                    ->where('status', '!=', 'Selesai')
                    ->orderBy('created_at','desc')
                    ->paginate(10);

        $historyuser = Transcation::when(request('search'), function($query){
                        return $query->where('invoices_number','like','%'.request('search').'%');
                    })
                    ->where('user_id', Auth()->id())
                    ->where('status', '!=', 'Selesai')
                    ->orderBy('created_at','desc')
                    ->paginate(10);

        $data['onprocess'] = Transcation::where('status', '!=', 'Selesai')->count();
        $data['onprocessuser'] = Transcation::where('status', '!=', 'Selesai')
                                    ->where('user_id', Auth::user()->id)
                                    ->count();

        return view('pos.history2',compact('history', 'historyuser', 'data'));
    }

    public function historyfinished(){
        $historyfinish = Transcation::when(request('search'), function($query){
                        return $query->where('invoices_number','like','%'.request('search').'%');
                    })
                    ->where('status', 'Selesai')
                    ->orderBy('created_at','desc')
                    ->paginate(10);

        $historyuserfinish = Transcation::when(request('search'), function($query){
                        return $query->where('invoices_number','like','%'.request('search').'%');
                    })
                    ->where('user_id', Auth()->id())
                    ->where('status', 'Selesai')
                    ->orderBy('created_at','desc')
                    ->paginate(10);

                    $data['done'] = Transcation::where('status', 'Selesai')->count();
                    $data['doneuser'] = Transcation::where('status', 'Selesai')
                                    ->where('user_id', Auth::user()->id)
                                    ->count();

        return view('pos.history',compact('historyfinish', 'historyuserfinish', 'data'));
    }

    public function laporan($id){
        $transaksi = Transcation::with('ProductTranscation')->find($id);
        
        return view('laporan.transaksi', compact('transaksi'));
    }

    public function cetak($id){
        $transaksi = Transcation::with('ProductTranscation')->find($id);
        
        return view('laporan.cetak', compact('transaksi'));
    }

    public function detail($id){
        $transaksi = Transcation::with('productTranscation')->find($id);
        return view('laporan.detail',compact('transaksi'));
    }

    public function complete(Request $request, $id){

        $tgl_kembali = request()->tgl_kembali;
        $diterima = request()->dikembalikan_pada;
        $damage_fine = request()->damage_fine;
        $pay = request()->pay;
        // dd($damage_fine);

        $terlambat = Carbon::parse($tgl_kembali)->diffInDays($diterima);

        $fine = 0;

        $denda = Transcation::select('transcations.invoices_number','product_transation.product_id','products.fine_price')
                                ->join('product_transation','product_transation.invoices_number','=','transcations.invoices_number')
                                ->join('products', 'products.id','=','product_transation.product_id')
                                ->where('transcations.invoices_number', $id)
                                ->get();

        foreach ($denda as $key => $value) {
            $product = Product::where('id', $value->product_id);
            $fine += $value->fine_price * $terlambat;
        }
        

        $grand_total = $pay + $damage_fine + $fine;
        // dd($fine);
        $transaksi = Transcation::find($id);
        $transaksi->update([
            'dikembalikan_pada' => $request->dikembalikan_pada,
            'damage_fine' => $request->damage_fine,
            'total_denda' => $fine,
            'grand_total' => $grand_total,
            'status' => 'Selesai'
        ]);

        $status = Transcation::select('transcations.invoices_number','product_transation.product_id')
                                ->join('product_transation','product_transation.invoices_number','=','transcations.invoices_number')
                                ->where('transcations.invoices_number', $id)
                                ->get();
        
        foreach ($status as $key => $value) {
            $product = Product::where('id', $value->product_id)->first();
            $product->status = 1;
            $product->save();
        }

        $message = 'Transaksi Berhasil di simpan';
        return redirect('/transaksi/history')->with('success',$message);  
    }

    public function perpanjang($id){
        $transaksi = Transcation::find($id);

        return view('laporan.perpanjang',compact('transaksi')); 
    }

    public function transfer($id){
        $transaksi = Transcation::find($id);
        
        return view('laporan.upload',compact('transaksi')); 
    }

    public function uploadbukti(Request $request, $id) {
        $transaksi = Transcation::find($id);



        $gambar = $request->image;
        $new_gambar = time().$gambar->getClientOriginalName();

        $transaksi->update([
            'bukti_pembayaran' => $new_gambar,
            'status' => 'Menunggu Verifikasi'
        ]);

        Image::make($gambar->getRealPath())->resize(null, 750, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/bukti_pembayaran/' . $new_gambar));

        $message = 'Berhasil upload bukti transfer! Silahkan tunggu untuk Admin memvalidasi pembayaran anda.';
        return redirect('/transaksi/onprocess')->with('success',$message);  
    }

    public function verify($id) {
        $transaksi = Transcation::find($id);

        return view('laporan.verify',compact('transaksi'));
    }

    public function verified(Request $request, $id){
        $transaksi = Transcation::find($id);

        $transaksi->update([
            'status' => 'Menunggu Diambil'
        ]);

        $message = 'Berhasil verfikasi transaksi '.$id;
        return redirect('/transaksi/onprocess')->with('success',$message);
    }

    public function invalid(Request $request, $id){
        $transaksi = Transcation::find($id);

        $transaksi->update([
            'status' => 'Menunggu Pembayaran',
            'bukti_pembayaran' => null
        ]);

        $message = 'Transaksi '.$id. ' tidak di-validasi';
        return redirect('/transaksi/onprocess')->with('success',$message);
    }

    public function approve($id) {
        $transaksi = Transcation::find($id);

        return view('laporan.approve',compact('transaksi'));
    }

    public function approved(Request $request, $id){
        $transaksi = Transcation::find($id);

        $transaksi->update([
            'status' => 'Sedang Dipinjam'
        ]);

        $message = 'Permintaan perpanjang transaksi '.$id. ' telah disetujui.';
        return redirect('/transaksi/onprocess')->with('success',$message);
    }

    public function update(Request $request, $id){
        $tgl_sewa = request()->tgl_sewa;
        $tgl_kembali = request()->tgl_kembali_lama;
        $tgl_kembali_lama = request()->tgl_kembali;
        $pay = request()->total;
        $harga_sewa = Carbon::parse($tgl_sewa)->diffInDays($tgl_kembali) * $pay;

        // dd($pay);

        $transaksi = Transcation::find($id);
        $transaksi->update([
            'tgl_kembali' => $request->tgl_kembali_lama,
            'tgl_kembali_lama' => $request->tgl_kembali,
            'pay' => $harga_sewa,
            'status' => 'Menunggu Persetujuan'
        ]);

        $message = 'Berhasil perpanjang transaksi '.$id;
        return redirect('/transaksi/onprocess')->with('success',$message);  
    }

    public function tolakperpanjang(Request $request, $id){
        $transaksi = Transcation::find($id);
        $tgl_kembali_lama = request()->tgl_kembali_lama;
        

        $transaksi->update([
            'tgl_kembali' => $request->tgl_kembali_lama,
            'tgl_kembali_lama' => null,
            'status' => 'Sedang Dipinjam'
        ]);

        $message = ' Perpanjangan Transaksi '.$id. ' ditolak';
        return redirect('/transaksi/onprocess')->with('success',$message);
    }

    public function cancel($id){
        $status = Transcation::select('transcations.invoices_number','product_transation.product_id')
                                ->join('product_transation','product_transation.invoices_number','=','transcations.invoices_number')
                                ->where('transcations.invoices_number', $id)
                                ->get();

        foreach ($status as $key => $value) {
            $product = Product::where('id', $value->product_id)->first();
            $product->status = 1;
            $product->save();
        }
        
        $transaksi = Transcation::find($id);
        $transaksi->delete();

        $produk = ProductTranscation::where('invoices_number', $id);
        $produk->delete();

        $message = 'Berhasil batalkan transaksi';
        return redirect('/transaksi/onprocess')->with('success', $message); 
    }

    public function ambil(Request $request, $id){
        $transaksi = Transcation::find($id);

        $transaksi->update([
            'status' => 'Sedang Dipinjam'
        ]);

        $message = 'Berhasil ubah status transaksi '.$id;
        return redirect('/transaksi/onprocess')->with('success',$message);
    }
    
}

