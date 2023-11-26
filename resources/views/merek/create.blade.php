@extends('layouts.app')

@section('title', 'Tambah Merk')

@section('content')

<div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-element-list">
                        <div class="basic-tb-hd">
                            <div class="col-lg-6"><h2>Tambah Merk</h2></div>
                            <div class="col-lg-6 text-right"><a href="{{ URL::previous() }}" class="btn btn-success btn-sm justify-content-end">
                                    <i class="fas fa-arrow-left"></i> Back</a></div>
                            
                            
                        </div>

                    <form action="{{ route('mereks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row" style="padding: 1px 20px;">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        
                                    </div>
                                    <div class="nk-int-st">
                                        <label for="name">Nama Merek</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nama Merk" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
<!-- © 2020 Copyright: Tahu Coding -->