@extends('layouts.app')

@section('title', 'Detail '.$transaksi->invoices_number  )

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
                                    <form action="{{ url('/transaksi/complete', $transaksi->invoices_number) }}" method="POST">
                                    @csrf
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
                                            <input id="pay" type="hidden" name="pay" value="{{$transaksi->pay}}">
                                        </tr>
                                        <tr>
                                            <th><b>Tanggal Sepeda Diterima</b></th>
                                            <td> : </td>
                                            <td><input id="dikembalikan_pada" class="form-control" type="date" name="dikembalikan_pada" required></td>
                                        </tr>
                                        <tr>
                                            <th><b>Biaya Kerusakan Sepeda</b></th>
                                            <td> : </td>
                                            <td><input id="damage_fine" class="form-control" type="number" name="damage_fine"></td>
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
                                        <th>Aksi</th>
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
                                                <td>
                                                    @if($item->product->lost == 0)
                                                        <a class="btn btn-primary btn-sm" data-trigger="hover" data-toggle="popover"
                                                                    data-placement="left" data-content="Input Kondisi Sepeda" href="{{route('product.inputkondisi', $item->product_id)}}">
                                                        <i class="fas fa-edit"></i></a>
                                                    @elseif(isset($item->product->kondisi))
                                                        <i class="fas fa-check" style="padding-left: 10px;"></i>
                                                    @elseif($item->product->lost == 1)
                                                        <i class="fas fa-check" style="padding-left: 10px;"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                                <td colspan="4"><button type="submit" class="btn btn-success">Simpan Transaksi</button></td>
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
        <div class="modal-content">
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

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            //ambil data kembali sepeda
            $( "#dikembalikan_pada" ).datetimepicker({
                timepicker: false,
                format: 'Y-m-d'
            });
            //ambil data tanggal kembali
            $( "#tgl_kembali" ).datetimepicker({
                timepicker: false,
                format: 'Y-m-d'
            });
        });

        function limiter() {
            var date1 = new Date ($("#dikembalikan_pada").val());
            var date2 = new Date ($("#tgl_kembali").val());
            var timeDiff = date1.getTime() - date2.getTime();

            if(date1 < date2){
                document.getElementById("denda").innerHTML = totalDenda ? 'Rp ' + rupiah(0) + ',00' : 'Rp ' + 0 +
                ',00';
            } else {
                var dayDiff = timeDiff / (1000 * 3600 * 24);

                var totalDenda = dayDiff * 2000;
                document.getElementById("denda").innerHTML = totalDenda ? 'Rp ' + rupiah(totalDenda) + ',00' + ' (' + dayDiff + ' Hari Terlambat)' : 'Rp ' + 0 +
                ',00';
            }
        }

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

@push('style')
<style>
    .gambarmodal {
            width: 80%;
            height: 80%;
            padding: 0.9rem 0.9rem
        }
</style>
@endpush