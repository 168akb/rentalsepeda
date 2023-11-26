@extends('layouts.app')

@section('title', 'Tambah Admin')

@section('content')

<div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @include('layouts.error', ['name' => 'name'])
                    @include('layouts.error', ['name' => 'email'])
                    <div class="form-element-list">
                        <div class="basic-tb-hd">
                            <h2>Tambah Admin Baru</h2>
                        </div>

                    <form action="{{ route('admins.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group ic-cmp-int float-lb floating-lb">
                                        <div class="form-ic-cmp">
                                        </div>
                                        <div class="nk-int-st">
                                            <label><strong>Nama Admin</strong></label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="row-py-2">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group ic-cmp-int float-lb floating-lb">
                                        <div class="form-ic-cmp">
                                        </div>
                                        <div class="nk-int-st">
                                            <label><strong>E-Mail</strong></label>
                                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><strong>Level</strong></label>
                                    <div class="fm-cmp-mg">
                                        <select name="level_id" id="level_id" class="form-control form-select-sm" required disabled>
                                        <option selected disabled >--- Pilih Merk ---</option>
                                        @foreach ($level as $level)
                                        <option value="{{$level->id}}" {{2 == $level->id ? 'selected' : ''}}>
                                            {{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <label><strong>Password</strong></label>
                                        <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Tambah Admin</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection