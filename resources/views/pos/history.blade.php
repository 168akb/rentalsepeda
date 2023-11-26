@extends('layouts.app')

@section('title','Riwayat Transaksi')

@section('content')

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
                                        <i class="notika-icon notika-windows"></i>
                                    </div>
                                    <div class="breadcomb-ctn">
                                        <h2>Riwayat Transaksi</h2>
                                        @if(Auth::user()->level_id != '3')
                                        <p><strong>{{$data['done']}}</strong> Total jumlah Transaksi Selesai.</p>
                                        @else
                                        <p><strong>{{$data['doneuser']}}</strong> Total jumlah Transaksi Selesai.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                                <!-- <div class="breadcomb-report">
                                    <button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></button>
                                </div> -->
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
                        <div class="basic-tb-hd">
                            <form action="{{ url('/transaksi/history') }}" method="get">
                                <div class="row">  
                                    <div class="nk-int-st search-input search-overt col"><input type="text" name="search"
                                            class="form-control form-control-sm col-sm-10 float-right"
                                            placeholder="Search Transaksi..." onblur="this.form.submit()">
                                    <button class="btn search-ib submit">Search</button>
                                    </div>
                                </div>
                            </form>
                            <!-- <h2>Basic Table</h2>
                            <p>Basic example without any additional modification classes</p> -->
                        </div>
                        <div class="bsc-tbl">
                            <table class="table table-sc-ex">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor Invoice</th>
                                        <th>Tanggal Sewa</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(Auth::user()->level_id == '3')
                                    @foreach ($historyuserfinish as $index=>$item)
                                    
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$item->invoices_number}}</td>
                                            <td>{{Carbon\Carbon::parse($item->tgl_sewa)->format('d F Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y')}}</td>
                                            <td>{{$item->user->name}}</td>
                                            <td>{{$item->status}}</td>
                                            
                                            <td><a href="{{url('/transaksi/laporan', $item->invoices_number )}}" class="btn btn-info btn-sm" 
                                                data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Cetak Invoice">
                                                <i class="fas fa-print"></i></a></td>
                                        </tr>
                                    @endforeach
                                    @endif 
                                    <!--Selesai Disini-->
                                    
                                    @if(Auth::user()->level_id == '2' || Auth::user()->level_id == '1')
                                    @foreach ($historyfinish as $index=>$item)
                                    
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$item->invoices_number}}</td>
                                            <td>{{Carbon\Carbon::parse($item->tgl_sewa)->format('d F Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y')}}</td>
                                            <td>{{$item->user->name}}</td>
                                            <td>{{$item->status}}</td>

                                            <td><a href="{{url('/transaksi/laporan', $item->invoices_number )}}" class="btn btn-info btn-sm" 
                                                data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Cetak Invoice">
                                                <i class="fas fa-print"></i></a></td>
                                        </tr>
                                    @endforeach
                                    @endif  
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>{{ $historyfinish->links() }}</div>
                </div>
            </div>
        </div>
    </div>
    
@include('layouts.checkdata')
    
@endsection