@extends('layouts.app')

@section('title', 'Validasi '.$transaksi->invoices_number  )

@section('content')
<div class="normal-table-area">
        <div class="container">

            @if(Session::has('success'))
            @include('layouts.flash-success',[ 'message'=> Session('success') ])
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list">
                        <div class="bsc-tbl">
                            <div class="container text-right" style="padding-right: 60px;">
                                <a href="{{ url('/transaksi/onprocess') }}" class=" btn btn-success btn-sm justify-content-end">
                                        <i class="fas fa-arrow-left"></i> Back</a>
                            </div>
                            <br>
                            <table class="table table-hover">
                                <tbody>
                                    <form action="{{ url('/transaksi/verified', $transaksi->invoices_number) }}" method="POST">
                                    @csrf
                                    <div class="col-lg-12 text-right" style="padding-left: 50px; padding-bottom: 10px"><img id="output" src="{{ asset('uploads/bukti_pembayaran/'.$transaksi->bukti_pembayaran) }}" class="img pripiw"></div>
                                    <br>
                                        <tr>
                                            <th width="40%"><b>Invoice Number</b></th>
                                            <td width="20%">: </td>
                                            <td width="30%"><b>{{$transaksi->invoices_number}}</b></td>
                                            <input id="invoices_number" type="hidden" name="invoices_number" value="{{$transaksi->invoices_number}}">
                                        </tr>
                                        <tr>
                                            <th><b>Nama Penyewa</b></th>
                                            <td>: </td>
                                            <td>{{$transaksi->user->name}}</td>
                                            <td width="10%"><a data-toggle="modal" data-target="#completedata" style="cursor: pointer;">Lihat KTP</a></td>
                                        </tr>
                                        <tr>
                                            <th><b>Tanggal Sewa</b></th>
                                            <td>: </td>
                                            <td>{{Carbon\Carbon::parse($transaksi->tgl_sewa)->format('d F Y')}}</td>
                                        </tr>
                                        <tr>
                                            <th><b>Tanggal Kembali</b></th>
                                            <td> : </td>
                                            <td>{{Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d F Y')}}</td>
                                            <input id="tgl_kembali" type="hidden" name="tgl_kembali" value="{{$transaksi->tgl_kembali}}">
                                        </tr>
                                        <tr>
                                            <th><b>Total Barang</b></th>
                                            <td> : </td>
                                            <td>Rp. {{ number_format($transaksi->total,2,',','.') }} x {{Carbon\Carbon::parse($transaksi->tgl_sewa)->diffInDays($transaksi->tgl_kembali)}} Hari</td>
                                        </tr>
                                        <tr>
                                            <th><b>Total Bayar</b></th>
                                            <td> : </td>
                                            <td>Rp. {{ number_format($transaksi->pay,2,',','.') }}</td>
                                        </tr>

                                </tbody>
                            </table>
                            <br>
                            <hr>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Satuan</th>
                                        <th>Harga Total</th>
                                    </tr>
                                </thead>
                                        <tbody>
                                            @foreach ($transaksi->productTranscation as $index=>$item)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$item->product->name}}</td>
                                                <td>Rp. {{ number_format($item->product->price,2,',','.') }} x 
                                                    ( {{Carbon\Carbon::parse($transaksi->tgl_sewa)
                                                    ->diffInDays($transaksi->tgl_kembali)}} Hari )</td>
                                                <td>
                                                    Rp. {{ number_format($item->product->price * Carbon\Carbon::parse($transaksi->tgl_sewa)
                                                    ->diffInDays($transaksi->tgl_kembali),2,',','.') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <td colspan="4"><button type="submit" onclick="return confirm('Validasi pembayaran ini?');" class="btn btn-success"><i class="fas fa-check"></i>     Validasi</button></td>
                                        </form>

                                        <form action="{{route('transaksi.invalid', $transaksi->invoices_number)}}" method="POST">
                                        @csrf
                                            <td><button type="submit" onclick="return confirm('Tolak validasi pembayaran ini?');" class="btn btn-danger"><i class="fas fa-trash"></i>     Tidak Valid</button></td>
                                        </form>
                                        </tr>
                                        
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


            <!-- Modal Complete Data -->
<div class="modal fade" role="dialog" id="completedata">
    <div class="modal-dialog modals-default modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px">
            <div class="modal-header">
            </div>

            <div class="modal-body">
                <h3>KTP Member : {{$transaksi->user->name}}</h3>
                <img class="card-img-top gambarmodal" src="{{ asset($transaksi->user->foto_ktp) }}" 
                                alt="Card image cap" align="text-center">
                
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Complete Data -->
@endsection

@push('style')
<style>
    .pripiw{
        width: 400px; 
        height: 300px; 
        object-fit: contain;
    }

    .gambarmodal {
            width: 80%;
            height: 80%;
            padding: 0.9rem 0.9rem
        }
</style>
    @endpush