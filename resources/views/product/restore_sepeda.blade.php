@extends('layouts.app')

@section('title', 'Daftar Sepeda Rusak')

@section('content')


        <div class="container">

            @if(Session::has('success'))
            @include('layouts.flash-success',[ 'message'=> Session('success') ])
            @endif

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <br>
                @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding-bottom: 20px">
                    <div class="contact-list">
                        <div class="contact-win">
                            <div class="container gambar">
                                <img src="{{asset($product->image) }}" alt="" />
                            </div>
                            <div class="conct-sc-ic">
                                <a class="btn" data-toggle="modal" data-target="#detail{{ $product->id }}" >
                                    <i class="notika-icon notika-search"></i></a>
                            </div>
                        </div>
                        <div class="contact-ctn">
                            <div class="contact-ad-hd">
                                <h2>{{ $product->name }}</h2>
                                <p class="ctn-ads">Rp. {{ number_format($product->price,2,',','.') }} /hari</p>
                            </div>
                        </div>
                        <div class="social-st-list">
                            <form action="{{route('product.cleardamage', $product->id)}}" method="POST">
                                @csrf
                            <button class="btn btn-primary btn-block btn-sm"
                                        onclick="return confirm('Perbaiki Sepeda ini?');">Perbaiki Sepeda</button>
                                    </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

<!-- Modal Detail Sepeda -->
@foreach($products as $p)
<div class="modal fade" role="dialog" id="detail{{ $p->id }}">
    <div class="modal-dialog modal-large">
        <div class="modal-content" style="border-radius: 10px">
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
                                <label>Nama</label>
                                <input  value="{{ $p->name }}" type="text" name="name" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>

                    <div class="row-py-2">
                        <div class="col">
                            <div class="form-group">
                                <label>Kondisi Sepeda</label>
                                <input value="{{ $p->kondisi }}" type="text" name="kondisi" class="form-control" readonly="">
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


    @endsection

    @push('style')
    <style>
        .gambar {
            width: 90%;
            height: 190px;
            padding: 0.9rem 0.9rem;
        }

        .gambarmodal {
            width: 80%;
            height: 50%;
            padding: 0.9rem 0.9rem
        }

        @media only screen and (max-width: 600px) {
            .gambar {
                width: 100%;
                height: 100%;
                padding: 0.9rem 0.9rem;
            }
        }
        .cart-btn {
            position: absolute;
            display: block;
            top: 4%;
            right: 3%;
            cursor: pointer;
        }

    </style>
    @endpush