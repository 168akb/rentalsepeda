@extends('layouts.app')

@section('title', 'Edit Sepeda')

@section('content')

<div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-element-list">
                        <div class="basic-tb-hd">
                            <div class="col-lg-6"><h2>Edit Sepeda</h2></div>
                            <div class="col-lg-6 text-right">
                                <form action="{{ route('products.destroy', $product->id ) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm float-left"
                                    onclick="return confirm('Apakah anda yakin menghapus data ini ?');">
                                    <i class="fas fa-trash"></i>       Hapus</button>
                                    <a href="{{ URL::previous() }}" class="btn btn-success btn-sm justify-content-end">
                                        <i class="fas fa-arrow-left"></i> Back</a></div>
                                </form>
                        </div>

                    <form action="{{ route('products.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$product->id}}">
                        <div class="row" style="padding: 1px 20px;">

                            <div class="col-lg-12" style="padding-left: 56px;"><img id="output" src="{{asset($product->image)}}" class="img pripiw"></div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        
                                    </div>
                                    <div class="nk-int-st">
                                        <label><strong>Gambar Sepeda</strong></label>
                                        <input name="image" id="image" type="file" class="form-control"
                                                accept="image/*"
                                                onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').style.display = 'none'">
                                    </div>
                                </div>
                            </div>

                            <div class="row-py-2" style="padding-left: 25px">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label><strong>Merk</strong></label>
                                    <div class="fm-cmp-mg">
                                        <select name="merek_id" id="merek_id" class="form-control form-select-sm">
                                        <option selected disabled >--- Pilin Merk ---</option>
                                        @foreach($merek as $merek)
                                        <option value="{{$merek->id}}" {{$product->merek_id == $merek->id ? 'selected' : ''}}>{{ $merek->name }}</option>
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
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" placeholder="Tipe Sepeda. Ex : Strada 3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row-py-2" style="padding-left: 25px">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label><strong>Kategori Sepeda</strong></label>
                                    <div class="fm-cmp-mg">
                                        <select name="sepeda_kategori_id" id="sepeda_kategori_id" class="form-control form-select-sm">
                                        <option selected disabled >--- Pilin Kategori ---</option>
                                        @foreach($sepeda_kategori as $sepeda_kategori)
                                        <option value="{{$sepeda_kategori->id}}" {{$product->sepeda_kategori_id == $sepeda_kategori->id ? 'selected' : ''}}>{{ $sepeda_kategori->name }}</option>
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
                                            <input type="number" class="form-control" name="price" value="{{ old('price' , $product->price) }}" placeholder="Harga Sepeda">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <label><strong>Deskripsi</strong></label>
                                        <textarea class="form-control" name="description" rows="5" placeholder="Ketik deskirpsi sepeda disini....">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @if($product->status == '0')
                            <div class="row-py-2" style="padding-left: 25px">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label><strong>Status Sepeda</strong></label>
                                    <div class="fm-cmp-mg">
                                        <select name="sepeda_kategori_id" id="sepeda_kategori_id" class="form-control form-select-sm">
                                        <option value="{{$product->status}}"/option>
                                      
                                    </select>
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <div class="form-group ic-cmp-int float-lb floating-lb">
                                        <div class="form-ic-cmp">
                                        </div>
                                        <div class="nk-int-st">
                                            <label><strong>Oleh :</strong></label>
                                            <input type="text" class="form-control" name="" value="{{ $namapeminjam->name }}"}>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else

                            @endif
                            <button type="submit" class="btn btn-success btn-block">Simpan Perubahan</button>
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

