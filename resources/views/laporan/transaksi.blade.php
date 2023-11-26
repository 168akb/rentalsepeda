@extends('layouts.app')

@section('title', 'Transaksi '.$transaksi->invoices_number  )

@section('content')
<!-- Invoice Print Area Start -->
    <div class="invoice-print">
        <a href="{{ route('transaksi.cetak', $transaksi->invoices_number) }}" class="btn"><i class="notika-icon notika-print"></i></a>
    </div>
    <!-- Breadcomb area Start-->
    <div class="breadcomb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcomb-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcomb-wp">
                                    <div class="breadcomb-icon">
                                        <i class="notika-icon notika-support"></i>
                                    </div>
                                    <div class="breadcomb-ctn">
                                        <h2>Invoice {{$transaksi->invoices_number}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                                <div class="breadcomb-report">
                                    <button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcomb area End-->
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
                                <a href="{{ url('/transaksi/history') }}" class=" btn btn-success btn-sm justify-content-end">
                                        <i class="fas fa-arrow-left"></i> Back</a>
                            </div>
                            <br>
                            <table class="table table-hover">
                                <tbody>
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
                                            <th><b>Denda</b></th>
                                            <td> : </td>

                                            <td>@if($transaksi->dikembalikan_pada <= $transaksi->tgl_kembali)
                                                -
                                                @else

                                                    @foreach ($transaksi->productTranscation as $index=>$item)
                                                    <tr>
                                                        <td colspan="1" style="padding-left: 60px">
                                                            {{$item->product->name}}
                                                        </td>
                                                        <td colspan="1" style="padding-right: 20px">
                                                            Rp. {{ number_format($item->product->fine_price,2,',','.') }} 
                                                            x 
                                                            {{ number_format(Carbon\Carbon::parse($transaksi->tgl_kembali)
                                                ->diffInDays($transaksi->dikembalikan_pada)) }} Hari
                                                        </td>
                                                        <td width="20%">
                                                            Rp. {{ number_format($item->product->fine_price * (Carbon\Carbon::parse($transaksi->tgl_kembali)
                                                ->diffInDays($transaksi->dikembalikan_pada)) ,2,',','.') }}
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><b>Tanggal Sepeda Diterima</b></th>
                                            <td> : </td>
                                            <td>{{Carbon\Carbon::parse($transaksi->dikembalikan_pada)->format('d F Y')}}</td>
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
                                        
                                        <thead>
                                            <td colspan="2">Total</td>
                                            <td>:</td>
                                            <td><strong>Rp. {{ number_format($transaksi->pay,2,',','.') }}</strong> </td>
                                            <br>
                                        </thead>
                                        <thead>
                                            <td colspan="2">Denda</td>
                                            <td>:</td>
                                            <td>@if($transaksi->dikembalikan_pada <= $transaksi->tgl_kembali)
                                                -
                                                @else
                                                <strong>Rp. {{ number_format($transaksi->total_denda,2,',','.') }}</strong> 
                                                @endif
                                                </td>
                                            <br>
                                        </thead>
                                        <thead>
                                            <td colspan="2">Denda Kerusakan</td>
                                            <td>:</td>
                                            <td>@if($transaksi->damage_fine == 0)
                                                -
                                                @else
                                                Rp. {{ number_format($transaksi->damage_fine,2,',','.') }}
                                                @endif
                                            </td>
                                            <br>
                                        </thead>
                                        <thead>
                                            <td colspan="2"><strong>Grand Total</strong></td>
                                            <td>:</td>
                                            <td>@if($transaksi->status != 'Selesai')
                                                -
                                                @else
                                                <strong>Rp. {{ number_format($transaksi->grand_total,2,',','.') }}</strong></td>
                                                @endif
                                            <br>
                                        </thead> 
                                        </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
