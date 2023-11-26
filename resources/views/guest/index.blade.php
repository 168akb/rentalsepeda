@extends('layouts.appguest')

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
                                    
                                        <div class="animation-img mg-b-15">
                                            <img class="gambar" src="{{ $product->image }}" alt="" />
                                            <button data-toggle="modal" data-target="#login" type="btn" class="btn btn-sm btn-success btn-sm cart-btn info-icon-next waves-effect"><i class="notika-icon notika-next"></i></button>
                                
                                        <button type="button" data-toggle="modal" data-target="#detail{{ $product->id }}" class="btn btn-sm btn-info info-icon-notika waves-effect"><i class="notika-icon notika-search"></i></button>

                                @else
                                    <form action="#" method="POST">
                                    @csrf
                                    <div class="animation-img mg-b-15">
                                        <img class="gambar" src="{{ $product->image }}" alt="" />
                            
                                    <button type="button" data-toggle="modal" data-target="#detail{{ $product->id }}" class="btn btn-sm btn-info info-icon-notika waves-effect"><i class="notika-icon notika-search"></i></button>
                                </form>
                                @endif
                        </div>

                            <div class="animation-ctn-hd">
                                <h5>{{Str::words($product->name,3)}}</h5>
                                <p>Rp. {{ number_format($product->price,2,',','.') }} /hari</p>
                                <button type="button" class="btn btn-xs btn-block btn-{{ $product->status ? 'success':'danger'}}" style="border-radius: 20px">{{ $product->status ? 'Tersedia' : 'Dipakai' }}</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>



                <div class="container col-lg-4 statistic-right-area" data-toggle="modal" data-target="#login">
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
                    <div style="overflow-y:auto;min-height:53vh;max-height:53vh" class="mb-3" data-toggle="modal" data-target="#login">

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
                                
                                
                                <tr>
                                    <td colspan="4" class="text-center">Empty Cart</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="60%">Sub Total</th>
                            <th width="40%" class="text-right"> </th>
                        </tr>
                        
                        <tr>
                            <th>Total</th>
                            <th class="text-right font-weight-bold"></th>
                        </tr>
                    </table>
                    <!-- Button -->
                    <div class="row">
                        <div class="col-sm-6">
                                <button class="btn btn-info btn-block notika-btn-info waves-effect" type="btn">Clear</button>
                        </div>
                        <div class="col-sm-6">
                            <a href="#">
                                <button class="btn btn-warning btn-block notika-btn-warning waves-effect" type="btn">Riwayat</button></a>
                        </div>
                    </div>
                    <br>
                    <div class="row-py-2">
                        <div class="col">
                            <button class="btn btn-success btn-block notika-btn-success waves-effect"
                                data-toggle="modal" data-target="#fullHeightModalRight" type="btn">Bayar</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- End Sale Statistic area-->

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
<!-- Modal Login -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="login">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content rounded-0">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Daftar untuk menyewa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <form>
          <div class="form-group">
            <label class="col-form-label">Silahkan lakukan login atau registrasi terlebih dahulu untuk melakukan peminjaman.</label>
          </div>
          <div class="form-group">
            <div class="form-group">
                                <a href="{{ route('login') }}">Login  </a>Atau
                                <a href="{{ route('register') }}"  >Registrasi</a>
                            </div>
          </div>
        </form>
      </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
  </div>
</div>
</div>

<!-- Start Footer area-->
    <div class="footer-copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="footer-copy-right">
                        <p>Copyright © 2018 
                        . All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection
   
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @if(Session::has('errorTransaksi'))
    <script>
        toastr.error(
            'Transaksi tidak valid | perhatikan jumlah pembayaran | cek jumlah product'
        )

    </script>
    @endif

    @if(Session::has('success'))
    <script>
        toastr.success(
            'Transaksi Sukses | Transaksi berhasi tersimpan'
        )

    </script>
    @endif

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
            height: 155px;
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
            top: 5%;
            right: 5%;
            cursor: pointer;
            transition: all 0.3s linear;
            

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
