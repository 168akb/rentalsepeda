@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<!-- Breadcomb area Start-->
    <div class="breadcomb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcomb-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcomb-wp">
                                    <div class="breadcomb-icon">
                                        <i class="notika-icon notika-windows"></i>
                                    </div>
                                    <div class="breadcomb-ctn">
                                        <h2>Edit Owner {{$user->name}}</h2>
                                        <p>Edit data pengguna di halaman ini.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcomb area End-->

<!-- Form Element area Start-->
    <div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @include('layouts.error', ['name' => 'name'])
                    @include('layouts.error', ['name' => 'email'])
                    <div class="form-element-list">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <label><strong>Nama Owner</strong></label>
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Full Name">
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
                                            <input type="text" class="form-control" name="email" value="{{ $user->email }}" placeholder="Email Address">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label><strong>Level</strong></label>
                                    <div class="fm-cmp-mg">
                                        <select name="level_id" id="level_id" class="form-control form-select-sm" required disabled>
                                        <option selected disabled >--- Pilih Level ---</option>
                                        @foreach ($level as $level)
                                        <option value="{{$level->id}}" {{1 == $level->id ? 'selected' : ''}}>
                                            {{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label><strong>Status User</strong></label>
                                    <div class="fm-cmp-mg ">
                                        
                                        <select name="active" id="active" class="form-control form-select-sm">
                                            <option selected disabled >--- Pilih Status ---</option>
                                            <option value="1" {{$user->active == '1' ? 'selected' : ''}}>Active</option>
                                            <option value="0" {{$user->active == '0' ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <label><strong>Password</strong></label>
                                        <input type="password" class="form-control" name="password" placeholder="Isi jika ingin diubah">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update Owner</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

