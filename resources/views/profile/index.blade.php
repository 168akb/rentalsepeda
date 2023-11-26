@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="normal-table-area">
        <div class="container">

            @if(Session::has('success'))
            @include('layouts.flash-success',[ 'message'=> Session('success') ])
            @endif
            <!-- Inbox area Start-->
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="inbox-left-sd">
						<div class="compose-ml">
							<form action="{{route('profile.edit')}}">
								<button class="btn">Edit Profil</button>
							</form>
                        </div>

                        <hr>
                        
                        <div class="inbox-status">
                            <ul class="inbox-st-nav inbox-ft">
                                <li>
                                    <div class="animation-img mg-b-15" style="padding-left: 10px;">

                                        @if(isset(Auth::user()->pfp))
                                        <img class="pfp" src="{{ asset(Auth::user()->pfp) }}" alt="" />
                                        @else
                                        <img class="pfp" src="{{ asset('uploads/pfp/default_pfp.png') }}" alt="" />
                                        @endif

                                    </div> 
                                </li>
                                <li><a href="#"><i class="notika-icon notika-sent"></i> <strong>{{ Auth::user()->email }}</strong></a></li>
                                <li><a href="#"><i class="notika-icon notika-support"></i> {{ Auth::user()->level->name }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <br>
                    @if(Auth::user()->level_id == '3')
                    <div class="inbox-left-sd">
                        <div class="compose-ml">
                            <form action="{{route('profile.uploadktp', Auth::user()->id)}}">

                                <button class="btn">Lihat KTP</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <div class="inbox-text-list sm-res-mg-t-30">

                        <div class="inbox-btn-st-ls btn-toolbar">
                            <div class="btn-group ib-btn-gp active-hook nk-email-inbox">
                                <h3>Informasi Pengguna</h3>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-inbox">
                                <tbody>
                        @if(Auth::user()->level_id != '3')
                                    <tr>
                                        <td><h5>Nama</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->name}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Jenis Kelamin</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->jenis_kelamin}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>E-Mail</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->email}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Role</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->level->name}}</h5>
                                        </td>
                                    </tr>
                        @else
                                    <tr>
                                        <td><h5>Nama</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->name}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Jenis Kelamin</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->jenis_kelamin}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>E-Mail</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->email}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Role</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->level->name}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Lembaga</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->lembaga}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Kota Asal</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->kota}}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>No. Telepon</h5></td>
                                        <td><h5>:</h5></td>
                                        <td><h5>{{Auth::user()->telepon}}</h5>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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