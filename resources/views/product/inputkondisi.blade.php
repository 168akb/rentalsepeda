@extends('layouts.app')

@section('title', 'Input Kondisi Sepeda')

@section('content')

<div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-element-list">
                        <div class="basic-tb-hd">
                            <div class="col-lg-6"><h2>Input Kondisi Sepeda</h2></div>
                            <a href="{{ URL::previous() }}" class=" btn btn-success btn-sm">
                                        <i class="fas fa-arrow-left"></i> Back</a>
                        </div>

                    <form action="{{route('product.tandaihilang', $product->id)}}" method="POST">
                        @csrf
                                                    <button class="btn btn-danger" data-trigger="hover" data-toggle="popover"
                                                                    data-placement="left" data-content="Tandai Hilang"
                                                        onclick="return confirm('Tandai sepeda sebagai hilang?');">
                                                        <i class="fas fa-trash"></i> Tandai sebagai hilang</button>
                    </form>

                    <form action="{{ route('product.damage', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$product->id}}">
                        <div class="row" style="padding: 1px 20px;">

                            <div class="col-lg-12" style="padding-left: 56px;"><img id="output" src="{{asset($product->image)}}" class="img pripiw"></div>
                            
                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <label><strong>Kondisi Sepeda</strong></label>
                                        <textarea class="form-control" name="kondisi" rows="5" placeholder="Ex : Rantai Putus, Sadel Brudul">{{ old('description', $product->kondisi) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Simpan</button>
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

