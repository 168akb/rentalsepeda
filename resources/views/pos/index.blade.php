@extends('layouts.app')

@section('title','Order Sepeda')

@section('content')
<div class="sale-statistic-area">
        <div class="container">
            <div class="row">
                <div class=" col-lg-8 col-xs-12 statistic-right-area">
                    
                    @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <div class="animation-single-int">
                                @if($product->status == 1)
                                    <form action="{{url('/transcation/addproduct', $product->id)}}" method="POST">
                                        @csrf
                                        <div class="animation-img mg-b-15">
                                            <img class="gambar" src="{{ $product->image }}" alt="" />
                                            <button type="submit" class="btn btn-sm btn-success cart-btn"><i class="fas fa-cart-plus"></i></button>
                                
                                        <button type="button" data-toggle="modal" data-target="#detail{{ $product->id }}" class="btn btn-sm btn-info detail-btn"><i class="fas fa-info"></i></button>
                                    </form>
                                @else
                                    <form action="#" method="POST">
                                    @csrf
                                    <div class="animation-img mg-b-15">
                                        <img class="gambar" src="{{ $product->image }}" alt="" />
                            
                                    <button type="button" data-toggle="modal" data-target="#detail{{ $product->id }}" class="btn btn-sm btn-info cart-btn"><i class="fas fa-info"></i></button>
                                </form>
                                @endif
                        </div>

                            <div class="animation-ctn-hd">
                                <h5>{{Str::words($product->name,3)}}</h5>
                                <p>Rp. {{ number_format($product->price,2,',','.') }} /hari</p>
                                <button type="button" class="btn btn-xs btn-block btn-{{ $product->status ? 'success':'danger'}}" style="border-radius: 25px;">{{ $product->status ? 'Tersedia' : 'Dipinjam' }}</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


                <div class="container col-lg-4 statistic-right-area">
                    @include('notify::components.notify')
                    <x:notify-messages />
                    @notifyJs
                        <div class="card-header bg-white">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h4 class="font-weight-bold">Cart</h4>
                                </div>
                                <div class="col-sm-8">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                    <div style="overflow-y:auto;min-height:53vh;max-height:53vh" class="mb-3">

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="30%">Nama Product</th>
                                    <th width="20%" class="text-right">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no=1
                                @endphp
                                @forelse($cart_data as $index=>$item)
                                <tr>
                                    <td>
                                        <form action="{{url('/transcation/removeproduct',$item['rowId'])}}"
                                            method="POST">
                                            @csrf
                                            {{$no++}} <br><a onclick="this.closest('form').submit();return false;"><i
                                                    class="fas fa-trash" style="cursor: pointer; color: rgb(134, 134, 134)"></i></a>
                                        </form>
                                    </td>
                                    <td><strong>{{$item['brand']}}</strong><br>{{Str::words($item['name'],3)}}</td>

                                    <td class="text-right">Rp. {{ number_format($item['price'],2,',','.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Empty Cart</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="60%">Sub Total</th>
                            <th width="40%" class="text-right">Rp.
                                {{ number_format($data_total['sub_total'],2,',','.') }} </th>
                        </tr>
                        
                        <tr>
                            <th>Total</th>
                            <th class="text-right font-weight-bold">Rp.
                                {{ number_format($data_total['total'],2,',','.') }}</th>
                        </tr>
                    </table>
                    <!-- Button -->
                    <div class="row">
                        <div class="col-sm-6">
                            <form action="{{ url('/transcation/clear') }}" method="POST">
                                @csrf
                                <button class="btn btn-info btn-block notika-btn-info waves-effect" type="submit">Clear</button>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{url('/transaksi/history')}}" target="_blank">
                                <button class="btn btn-warning btn-block notika-btn-warning waves-effect">Riwayat</button></a>
                        </div>
                    </div>
                    <br>
                    <div class="row-py-2">
                        <div class="col">
                            <button class="btn btn-success btn-block notika-btn-success waves-effect"
                                data-toggle="modal" data-target="#fullHeightModalRight">Bayar</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div>{{$products->links()}}</div>
        </div>
</div>
<!-- End Sale Statistic area-->


<!-- Modal Pembayaran -->   
<div id="fullHeightModalRight" class="modal fade" tabindex="-1" role="dialog">
<div class="container">
  <div class="modal-dialog-right modal-large" role="document">
        <div class="modal-content modal-content-right">
            <div class="modal-header"> 
            </div>

            <div class="modal-body">
                <h3 class="text-center">Konfirmasi Pembayaran</h3>
                <hr>
                <br>
            <form action="{{ url('/transcation/bayar') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Atas Nama</label>
                    <div class="nk-int-st">
                        <input id="" class="form-control" type="text" name="atas_nama" value="{{Auth::user()->name}}" readonly/>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-6">
                            <label for="tgl_sewa">Tanggal Sewa</label>
                            <input id="tgl_sewa" class="form-control" type="date" name="tgl_sewa" required/>
                    </div>
                    <div class="col-sm-6">
                            <label for="tgl_kembali">Tanggal Kembali</label>
                            <input id="tgl_kembali" class="form-control" type="date" name="tgl_kembali" required/>
                    </div>
                </div>

                <div class="row-py-2 form-group">
                    <div class="nk-int-mk sl-dp-mn">
                        <label for="metode">Metode Pembayaran</label>
                    </div>
                    <div class="fm-cmp-mg">
                        <select class="form-control form-select-sm" name="metode" id="metode">
                            <option selected disabled >--- Pilih Metode Pembayaran ---</option>
                            <option value="Tunai" >Tunai</option>
                            <option value="Transfer" >Transfer</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="padding-top: 15px;">
                    <h1 class="font-weight-bold"><b>Total:</b></h1>
                    <h1 class="font-weight-bold mb-5"><b>Rp. {{ number_format($data_total['total'],2,',','.') }}</b></h1>
                    <input id="totalHidden" type="hidden" name="totalHidden" value="{{$data_total['total']}}" />
                </div>    

                <div class="row form-group" style="padding-top: 15px;">
                        <div class="col-sm-6">
                                <h1 class="font-weight-bold"><b> Jumlah Bayar:</b></h1>
                                <b class="font-weight-bold mb-5" id="total_bayar"></b>
                        </div>
                        <div class="col-sm-6">
                                <h4 class="font-weight-bold"></h4>
                                <b class="font-weight-bold my-4" id="jumlahhari"></b>
                        </div>
                </div>
            </div>
            <div class="modal-footer text-end" style="position: absolute; bottom: 20px; width: 90%;">
                <hr>
                <div class="form-group">

                    <div class="col-sm-6">
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary btn-block" id="saveButton" onClick="openWindowReload(this)">Buat Pesanan</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
</div>

     
<!-- Modal Detail Sepeda -->
@foreach($products as $p)
<div class="modal fade" role="dialog" id="detail{{ $p->id }}">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h2>Detail Sepeda</h2>
                <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col">
                            <div id="carouselId" class="carousel" data-ride="carousel">
                                <img class="card-img-top gambarmodal" src="{{ asset($p->image) }}" 
                                alt="Card image cap" align="text-center">
                            </div>
                        </div>
                    </div>
                </div>      
            

            <div class="col-lg-5">

                    <div class="row-py-2">
                        <div class="col">
                            <div class="form-group">
                                <label>Nama</label>
                                <input  value="{{ $p->name }}" type="text" name="name" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Merk</label>
                                <input value="{{ $p->merek->name }}" type="text" name="manufacture" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Jenis</label>
                                <input value="{{ $p->sepeda_kategori->name }}" type="text" name="year" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="row-py-2">
                        <div class="col">
                            <div class="form-group">
                                <label>Harga</label>
                                <input value="Rp. {{ number_format($p->price,2,',','.') }}" type="text" name="license_number" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="row-py-2">
                        <div class="col">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input value="{{ $p->description }}" type="text" name="penalty" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>

            </div>
        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- End of Modal Detail Sepeda -->

@include('layouts.checkdata')

    @endsection
   
    @push('script')

    <script>

        $(document).ready(function () {
            $('#fullHeightModalRight').on('shown.bs.modal', function () {
                $('#oke').trigger('focus');
            });

        });

        tgl_kembali.oninput = function () {
            let total = parseInt(document.getElementById('totalHidden').value) ? parseInt(document.getElementById('totalHidden').value) : 0;

            var date1 = new Date ($("#tgl_sewa").val());
            var date2 = new Date ($("#tgl_kembali").val());
            var timeDiff = date2.getTime() - date1.getTime();

            var dayDiff = timeDiff / (1000 * 3600 * 24);
            var akhir = total * dayDiff;
            document.getElementById("total_bayar").innerHTML = akhir ? 'Rp ' + rupiah(akhir) + ',00' : 'Rp ' + 0 +
                ',00';
            document.getElementById("jumlahhari").innerHTML = dayDiff + ' Hari';
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <style>
        .gambarmodal {
            width: 100%;
            height: 0%;
            padding: 0.9rem 0.9rem
        }

        .gambar {
            width: 100%;
            height: 135px;
            padding: 0.9rem 0.9rem
        }

        @media only screen and (max-width: 600px) {
            .gambar {
                width: 100%;
                height: 100%;
                padding: 0.9rem 0.9rem
            }
        }

        html {
            overflow: scroll;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar-thumb {
            background: #FF0000;
        }

        .cart-btn {
            position: absolute;
            width: 35px;
            height: 35px;
            top: 5%;
            right: 5%;
            cursor: pointer;
            transition: all 0.3s linear;
            border-radius: 50px;
        }

        .detail-btn {
            position: absolute;
            width: 35px;
            height: 35px;
            top: 20%;
            right: 5%;
            cursor: pointer;
            transition: all 0.3s linear;
            border-radius: 50px;
        }

        .modal-dialog-right {
            position: fixed;
            margin: auto;
            width: 330px;
            height: 100%;
            right: 0px;
        }
        .modal-content-right {
            padding: 20px 15px;
            height: 100%;
        }

        .productCard {
            cursor: pointer;

        }

        .productCard:hover {
            border: solid 1px;

        }

    </style>
    @endpush
