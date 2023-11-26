@extends('layouts.app')

@section('title', 'Perpanjang '.$transaksi->invoices_number  )

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
                                    <form action="{{ url('/transaksi/update', $transaksi->invoices_number) }}" method="POST">
                                    @csrf
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
                                            <input id="tgl_sewa" type="hidden" name="tgl_sewa" value="{{$transaksi->tgl_sewa}}">
                                        </tr>
                                        <tr>
                                            <th><b>Tanggal Kembali</b></th>
                                            <td> : </td>
                                            <td>{{Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d F Y')}}</td>
                                            <input id="tgl_kembali" type="hidden" name="tgl_kembali" value="{{$transaksi->tgl_kembali}}">
                                        </tr>
                                        <tr>
                                            <th><b>Tanggal Kembali Baru</b></th>
                                            <td> : </td>
                                            <td><input id="tgl_kembali_lama" class="form-control" type="date" 
                                                name="tgl_kembali_lama" 
                                                value="{{$transaksi->tgl_kembali_lama}}" 
                                                required/></td>
                                        </tr>

                                        <tr>
                                            <th><b>Total Barang</b></th>
                                            <td> : </td>
                                            <td>Rp. {{ number_format($transaksi->total,2,',','.') }} x {{Carbon\Carbon::parse($transaksi->tgl_sewa)->diffInDays($transaksi->tgl_kembali)}} Hari</td>
                                            <input id="total" type="hidden" name="total" value="{{$transaksi->total}}">
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
                                                <td colspan="3"><button type="submit" class="btn btn-success">Update Transaksi</button></td>
                                            </tr>
                                        </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            //ambil data tanggal kembali
            $( "#tgl_kembali" ).datetimepicker({
                timepicker: false,
                format: 'Y-m-d'
            });
        });


        function rupiah(bilangan) {
            var number_string = bilangan.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

    </script>

@endpush