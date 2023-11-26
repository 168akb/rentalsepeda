@extends('layouts.app')

@section('title','Transaksi Dalam Proses')

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
                                        <h2>Transaksi dalam Proses</h2>
                                        @if(Auth::user()->level_id != '3')
                                        <p><strong>{{$data['onprocess']}}</strong> Total jumlah Transaksi dalam proses.</p>
                                        @else
                                        <p><strong>{{$data['onprocessuser']}}</strong> Total jumlah Transaksi dalam proses.</p>
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
                            <form action="{{ url('/transaksi/onprocess') }}" method="get">
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
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <!--Tampilan untuk user MEMBER-->
                    @if(Auth::user()->level_id == '3')
                    @forelse ($historyuser as $index=>$item)
                        
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$item->invoices_number}}</td>
                                <td>{{Carbon\Carbon::parse($item->tgl_sewa)->format('d F Y')}}</td>
                                <td>{{Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y')}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>Rp. {{ number_format($item->pay,2,',','.') }}</td>
                                <td>{{$item->status}}</td>

                            @if($item->status == 'Sedang Dipinjam')
                                    <td><a href="{{url('/transaksi/laporan', $item->invoices_number )}}" class="btn btn-warning btn-sm"
                                    data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Detail Transaksi">
                                    <i class="fas fa-eye"></i></a></td>

                                    <td><a href="{{ url('/transaksi/perpanjang', $item->invoices_number) }}" 
                                        class="btn btn-success btn-sm" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Perpanjang Sewa">
                                        <i class="fas fa-clock"></i></a></td>

                            @elseif($item->status == 'Menunggu Pembayaran')
                                    <td><a href="{{ url('/transaksi/upload', $item->invoices_number) }}" 
                                        class="btn btn-success btn-sm" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Upload Bukti Pembayaran">
                                        <i class="fas fa-upload"></i></a></td>

                                    <td><a href="{{route('transaksi.cancel', $item->invoices_number )}}" 
                                        class="btn btn-danger btn-sm" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Batalkan Transaksi" onclick="return confirm('Apakah anda yakin menghapus data ini ?')">
                                        <i class="fas fa-trash"></i></a></td>
                            @else <!-- Menunggu Validasi Admin -->
                                    <td><a href="{{url('/transaksi/laporan', $item->invoices_number )}}" 
                                        class="btn btn-warning btn-sm" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Detail Transaksi">
                                        <i class="fas fa-eye"></i></a></td>
                            @endif

                            @if($item->status == 'Selesai')
                                    <td><a href="{{url('/transaksi/laporan', $item->invoices_number )}}" class="btn btn-info btn-sm"><i class="fas fa-print" title="Cetak"></i></a></td>
                            @endif
                                </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                        @endif 
                            <!--Selesai Disini-->
                            
                            <!--Tampilan untuk user ADMIN dan OWNER-->
                        @if(Auth::user()->level_id == '2' || Auth::user()->level_id == '1')
                        @forelse ($history as $index=>$item)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->invoices_number}}</td>
                                    <td>{{Carbon\Carbon::parse($item->tgl_sewa)->format('d F Y')}}</td>
                                    <td>{{Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y')}}</td>
                                    <td>{{$item->user->name}}</td>
                                    <td>Rp. {{ number_format($item->pay,2,',','.') }}</td>
                                    <td>{{$item->status}}</td>

                            @if($item->status == 'Sedang Dipinjam')
                                    <td><a href="{{url('/transaksi/detail', $item->invoices_number )}}" 
                                        class="btn btn-success btn-sm" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Selesaikan Transaksi"> 
                                        <i class="fas fa-check"></i></a></td>
                                </tr>
                            @elseif($item->status == 'Menunggu Verifikasi')
                                    <td><a href="{{url('/transaksi/verify', $item->invoices_number )}}" 
                                        class="btn btn-primary btn-sm popovers" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Verifikasi Pembayaran">
                                        <i class="fas fa-check" title="Verifikasi Pembayaran"></i></a></td>
                                </tr>
                            @elseif($item->status == 'Menunggu Persetujuan')
                                    <td><a href="{{url('/transaksi/approve', $item->invoices_number )}}" 
                                        class="btn btn-primary btn-sm popovers" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Setujui Permintaan">
                                        <i class="fas fa-check" title="Setujui Permintaan"></i></a></td>
                                </tr>
                            @elseif($item->status == 'Menunggu Diambil')
                            
                                    <td>
                                        <form action="{{ route('transaksi.ambil', $item->invoices_number) }}" method="POST">
                                            @csrf
                                        <button  onclick="return confirm('Ubah status menjadi sudah diambil?');" type="submit" class="btn btn-primary btn-sm popovers" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Tandai sudah diambil"><i class="fas fa-check"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                            @if($item->status == 'Selesai')
                                    <td><a href="{{url('/transaksi/laporan', $item->invoices_number )}}" 
                                        class="btn btn-info btn-sm" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Cetak Invoice"><i class="fas fa-print" title="Cetak"></i></a></td>
                                </tr>
                            @endif
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                        @endif
                            <!--Selesai Disini-->    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>{{ $history->links() }}</div>
                </div>
            </div>
        </div>
    </div>

@include('layouts.checkdata')

@endsection