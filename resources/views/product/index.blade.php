@extends('layouts.app')

@section('title', 'Daftar Sepeda')

@section('content')

        <div class="container">

            @if(Session::has('success'))
            @include('layouts.flash-success',[ 'message'=> Session('success') ])
            @endif

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list">
                        <div class="basic-tb-hd">
                            <form action="{{ route('products.index') }}" method="get">
                                <div class="row">  
                                    <div class="nk-int-st search-input search-overt col"><input type="text" name="search"
                                            class="form-control form-control-sm col-sm-10 float-right"
                                            placeholder="Search Product..." onblur="this.form.submit()">
                                    <button class="btn search-ib submit">Search</button>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="col"><a href="{{route('products.create')}}"
                                    class="btn btn-success btn-sm float-right btn-block">Tambah Sepeda</a></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="container" style="padding: 10px;">
                        <a data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Data Terhapus" href="{{ url('/sepeda/products/bin')}}" class="btn btn-danger btn-sm justify-content-end float-right">
                            <i class="fas fa-trash"></i></a>
                    </div>
                @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding-bottom: 20px">
                    <div class="contact-list">
                        <div class="contact-win">
                            <div class="container">
                                <img src="{{asset($product->image) }}" class="gambar" />
                            </div>
                            <div class="conct-sc-ic">
                                <a class="btn" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Edit Data" href="{{route('products.edit', $product->id)}}">
                                    <i class="notika-icon notika-menu"></i></a>

                                <a class="btn" data-toggle="modal" data-target="#detail{{ $product->id }}" >
                                    <i class="notika-icon notika-search"></i></a>
                            </div>
                        </div>
                        <div class="contact-ctn">
                            <div class="contact-ad-hd">
                                <h2>{{ $product->name }}</h2>
                                <p class="ctn-ads">Rp. {{ number_format($product->price,2,',','.') }} /hari</p>
                            </div>
                            <!-- <p>Lorem ipsum dolor sit amete of the, consectetur.</p> -->
                        </div>
                        <div class="social-st-list">
                            <button type="button" class="btn btn-xs btn-block btn-{{ $product->status ? 'success':'danger'}}" style="border-radius: 20px">{{ $product->status ? 'Tersedia' : 'Dipinjam' }}</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div>{{ $products->links() }}</div>
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

                    <div class="row form-group">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Harga</label>
                                <input value="Rp. {{ number_format($p->price,2,',','.') }}" type="text" name="manufacture" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Harga Denda</label>
                                <input value="Rp. {{ number_format($p->fine_price,2,',','.') }}" type="text" name="year" class="form-control" readonly="">
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
                    @if($product->status == 1)
                    <div class="row-py-2">
                        <div class="col">
                            <div class="form-group">
                                <label>Status</label>
                                <button type="button" class="btn btn-xs btn-block btn-success" style="border-radius: 20px">Tersedia</button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row-py-2">
                        <div class="col">
                            <div class="form-group">
                                <label>Status</label>
                                <button type="button" class="btn btn-xs btn-block btn-danger" style="border-radius: 20px">Dipinjam</button>
                                <h2>Oleh:{{ $namapeminjam->name }} </h2>
                            </div>
                        </div>
                    </div>
                    @endif
            </div>
        </div>
            </div>
            <div class="modal-footer">
                    
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
            width: 200px; 
            height: 200px; 
            object-fit: contain;
        }

        .gambarmodal {
            width: 80%;
            height: 50%;
            padding: 0.9rem 0.9rem
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