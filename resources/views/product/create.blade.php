@extends('layouts.app')

@section('title', 'Tambah Sepeda')

@section('content')

<div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-element-list">
                        <div class="basic-tb-hd">
                            <div class="col-lg-6"><h2>Tambah Sepeda</h2></div>
                            <div class="col-lg-6 text-right"><a href="{{ URL::previous() }}" class="btn btn-success btn-sm justify-content-end">
                                    <i class="fas fa-arrow-left"></i> Back</a></div>
                            
                            
                        </div>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row" style="padding: 1px 20px;">

                            <div class="col-lg-12" style="padding-left: 56px;"><img id="output" src="{{asset('uploads/preview.jpg')}}" class="img pripiw"></div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <label><strong>Gambar Sepeda</strong></label>
                                    <div class="nk-int-st">
                                        <input name="image" id="image" type="file" class="form-control"
                                                accept="image/*"
                                                onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').style.display = 'none'" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row-py-2" style="padding-left: 25px">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label><strong>Merk</strong></label>
                                    <div class="fm-cmp-mg">
                                        <select name="merek_id" id="merek_id" class="form-control form-select-sm" required>
                                        <option selected disabled >--- Pilih Merk ---</option>
                                        @foreach($merek as $merek)
                                        <option value="{{$merek->id}}" >{{$merek->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <div class="form-group ic-cmp-int float-lb floating-lb">
                                        <div class="form-ic-cmp">
                                        </div>
                                        <div class="nk-int-st">
                                            <label><strong>Tipe Sepeda</strong></label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Tipe Sepeda. Ex : Strada 3" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row-py-2" style="padding-left: 25px">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label><strong>Kategori</strong></label>
                                    <div class="fm-cmp-mg">
                                        <select name="sepeda_kategori_id" id="sepeda_kategori_id" class="form-control form-select-sm" required>
                                        <option selected disabled >--- Pilih Kategori ---</option>
                                        @foreach($sepeda_kategori as $sepeda_kategori)
                                        <option value="{{$sepeda_kategori->id}}" >{{ $sepeda_kategori->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <div class="form-group ic-cmp-int float-lb floating-lb">
                                        <div class="form-ic-cmp">
                                        </div>
                                        <div class="nk-int-st">
                                            <label><strong>Harga Sewa</strong></label>
                                            <input type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="Harga Sepeda" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <label><strong>Deskripsi Sepeda</strong></label>
                                        <textarea value="{{ old('description') }}" class="form-control" name="description" rows="5" placeholder="Ketik deskirpsi sepeda disini...." required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Tambah Sepeda</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection

<style>
    .pripiw{
        width: 400px; 
        height: 300px; 
        object-fit: contain;
    }
</style>