@extends('layouts.app')

@section('title', ' Update Profil Pengguna')

@section('content')

<div class="normal-table-area">
        <div class="container">

            @if(Session::has('success'))
            @include('layouts.flash-success',[ 'message'=> Session('success') ])
            @endif
            <!-- Inbox area Start-->
            <form action="{{route('profile.update' )}}" method="POST" enctype="multipart/form-data">
            @csrf     
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap">

                        <div class="cmp-tb-hd">
                            <div class="col-lg-6"><h2>Edit Profil</h2></div>
                            <div class="col-lg-6 text-right"><a href="{{route('profile.index')}}" class="btn btn-success btn-sm justify-content-end"><i class="fas fa-arrow-left"></i> Back</a></div>
                        </div>

                        @if(Auth::user()->level_id != '3')
                        <div class="form-example-int" style="padding-top: 30px">
                            @if(isset(Auth::user()->pfp))
                            <div class="col-lg-12" style="padding-left: 56px; padding-bottom: 20px"><img id="output" src="{{asset(Auth::user()->pfp)}}" class="pfp"></div>
                            @else
                            <div class="col-lg-12" style="padding-left: 56px; padding-bottom: 20px"><img id="output" src="{{ asset('uploads/pfp/default_pfp.png') }}" class="pfp"></div>
                            @endif
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <input name="pfp" id="pfp" type="file" class="form-control"
                                                accept="image/*"
                                                onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').style.display = 'none'">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-example-int">
                            <div class="form-group">
                                <label><strong>Nama</strong></label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control input-sm" name="name" value="{{ Auth::user()->name }}" placeholder="Nama Pengguna" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int mg-t-15">
                            <div class="fm-cmp-mg">
                                <label><strong>Jenis Kelamin</strong></label><br>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control form-select-sm" required>
                                        <option selected disabled >--- Pilih Jenis Kelamin ---</option>
                                        
                                        <option value="Laki-laki" {{Auth::user()->jenis_kelamin == 'Laki-laki' ? 'selected' : ''}}>Laki-laki</option>
                                        <option value="Perempuan" {{Auth::user()->jenis_kelamin == 'Perempuan' ? 'selected' : ''}}>Perempuan</option>
                                        
                                    </select>
                            </div>
                        </div>


                        @else


                        <div class="form-example-int" style="padding-top: 30px">
                            @if(isset(Auth::user()->pfp))
                            <div class="col-lg-12" style="padding-left: 56px; padding-bottom: 20px"><img id="output" src="{{asset(Auth::user()->pfp)}}" class="pfp"></div>
                            @else
                            <div class="col-lg-12" style="padding-left: 56px; padding-bottom: 20px"><img id="output" src="{{ asset('uploads/pfp/default_pfp.png') }}" class="pfp"></div>
                            @endif

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                    </div>
                                    <div class="nk-int-st">
                                        <input name="pfp" id="pfp" type="file" class="form-control"
                                                accept="image/*"
                                                onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').style.display = 'none'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int">
                            <div class="form-group">
                                <label><strong>Nama</strong></label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control input-sm" name="name" value="{{ Auth::user()->name }}" placeholder="Full Name">
                                </div>
                            </div>
                        </div>

                        <div class="form-example-int mg-t-15">
                            <div class="form-group">
                                <label><strong>Lembaga Asal</strong></label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control input-sm" name="lembaga" value="{{ Auth::user()->lembaga }}" placeholder="Lembaga Asal">
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int mg-t-15">
                            <div class="form-group">
                                <label><strong>No. Telepon</strong></label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control input-sm" name="telepon" value="{{ Auth::user()->telepon }}" placeholder="Nomor Telepon Anda">
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int mg-t-15">
                            <div class="form-group">
                                <label><strong>Kota Asal</strong></label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control input-sm" name="kota" value="{{ Auth::user()->kota }}" placeholder="Kota asal anda">
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int mg-t-15">
                            <div class="fm-cmp-mg">
                                <label><strong>Jenis Kelamin</strong></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control form-select-sm">
                                        <option selected disabled >--- Pilih Jenis Kelamin ---</option>
                                        
                                        <option value="Laki-laki" {{Auth::user()->jenis_kelamin == 'Laki-laki' ? 'selected' : ''}}>Laki-laki</option>
                                        <option value="Perempuan" {{Auth::user()->jenis_kelamin == 'Perempuan' ? 'selected' : ''}}>Perempuan</option>
                                        
                                    </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-example-int mg-t-15">
                            <button class="btn btn-success notika-btn-success Submit">Update Profil</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
    <!-- Inbox area End-->
        </div>
    </div>
@endsection

@push('style')
<style type="text/css">
.pfp{
    clip-path: circle();
    width: 170px;
    height: 170px;

}
</style>
@endpush