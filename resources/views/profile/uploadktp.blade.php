@extends('layouts.app')

@section('title', ' Upload KTP Pengguna')

@section('content')

<div class="normal-table-area">
        <div class="container">

            @if(Session::has('success'))
            @include('layouts.flash-success',[ 'message'=> Session('success') ])
            @endif
            <!-- Inbox area Start-->
              
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap">

                        <div class="cmp-tb-hd">
                            <div class="col-lg-6"><h2>Upload Foto KTP</h2></div>
                            <div class="col-lg-6 text-right"><a href="{{route('profile.index')}}" class="btn btn-success btn-sm justify-content-end"><i class="fas fa-arrow-left"></i> Back</a></div>
                        </div>

                        <form action="{{route('profile.uploadktp' )}}" method="POST" enctype="multipart/form-data">
                        @csrf                       
                        <div class="form-example-int">
                            @if(empty(Auth::user()->foto_ktp))
                            <div class="col-lg-12" style="padding-left: 56px;"><img id="output" src="{{asset('uploads/preview.jpg')}}" class="img pripiw"></div>
                            @else
                            <div class="col-lg-12" style="padding-left: 56px; padding-bottom: 20px"><img id="output" src="{{asset(Auth::user()->foto_ktp)}}" class="pripiw"></div>
                            @endif
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <input name="foto_ktp" id="foto_ktp" type="file" class="form-control"
                                                accept="image/*"
                                                onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').style.display = 'none'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success notika-btn-success Submit">Update KTP</button>
                    </div>
                </div>
            </div>
            </form>
    <!-- Inbox area End-->
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