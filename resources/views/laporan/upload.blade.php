@extends('layouts.app')

@section('title', 'Upload Bukti Transaksi')

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
                                <a data-toggle="modal" data-target="#completedata" style="cursor: pointer; padding-right: 20px;">No. Rekening Pembayaran</a>
                                <a href="{{ url('/transaksi/onprocess') }}" class=" btn btn-success btn-sm justify-content-end">
                                        <i class="fas fa-arrow-left"></i> Back</a>
                            </div>
                            <br>
                            <table class="table table-hover">
                                <tbody>
                                    <form action="{{ url('/transaksi/uploadbukti', $transaksi->invoices_number) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-lg-12 text-right" style="padding-left: 50px; padding-bottom: 10px"><img id="output" src="{{asset('uploads/preview.jpg')}}" class="img pripiw"></div>
                                    <br>
                                        <tr>
                                            <td><b>Bukti Transfer</b></td>
                                            <td> : </td>
                                            <td>
                                                <div class="custom-file">
                                                <input name="image" id="image" type="file" class="file-input"
                                                        accept="image/*"
                                                        onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required>
                                                
                                                </div>
                                            </td>              
                                        </tr>
                                        <tr>
                                            <th width="40%"><b>Invoice Number</b></th>
                                            <td width="20%">: </td>
                                            <td width="40%"><b>{{$transaksi->invoices_number}}</b></td>
                                            <input id="invoices_number" type="hidden" name="invoices_number" value="{{$transaksi->invoices_number}}">
                                        </tr>
                                        <tr>
                                            <th><b>Nama Penyewa</b></th>
                                            <td>: </td>
                                            <td>{{$transaksi->user->name}}</td>
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
                                                <td colspan="4"><button type="submit" class="btn btn-success">Upload Pembayaran</button></td>
                                            </tr>
                                        </form>
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
                <h3>Transfer Pembayaran</h3>
                <p>Transfer ke No. Rekening BCA <strong>5227382910 a.n. : Raharja</strong> dengan jumlah nominal <strong>Rp. {{ number_format($transaksi->pay,2,',','.') }}</strong>.</p>
                <p>Kemudian upload bukti pembayaran ke form ini.</p>
                
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Complete Data -->
@endsection

@push('script')
<script>
    $(window).on('load', function() {
        $('#completedata').modal({
            keyboard: false
        });
    });

</script>
@endpush

<style>
    .pripiw{
        width: 400px; 
        height: 300px; 
        object-fit: contain;
</style>

