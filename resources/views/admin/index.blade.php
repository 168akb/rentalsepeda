@extends('layouts.app')

@section('title', 'Daftar Admin')

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
                                        <h2>List Admin</h2>
                                        <p><strong>{{$data['totalAdmin']}}</strong> Total jumlah Admin.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                                <div class="breadcomb-report">
                                    <button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcomb area End-->

<div class="normal-table-area">
        <div class="container">

            @if(Session::has('success'))
            @include('layouts.flash-success',[ 'message'=> Session('success') ])
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list">
                        <div class="basic-tb-hd">
                            <form action="{{ route('users.index') }}" method="get">
                                <div class="row">  
                                    <div class="nk-int-st search-input search-overt col"><input type="text" name="search"
                                            class="form-control form-control-sm col-sm-10 float-right"
                                            placeholder="Search Admin..." onblur="this.form.submit()">
                                    <button class="btn search-ib submit">Search</button>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="col"><a href="{{route('admins.create')}}"
                                    class="btn btn-success btn-sm float-right btn-block">Tambah Admin</a></div>
                                </div>
                            </form>
                            <!-- <h2>Basic Table</h2>
                            <p>Basic example without any additional modification classes</p> -->
                        </div>
                        <div class="bsc-tbl">
                            <table class="table table-hover">
                                <thead>
                                    @php $no = 1; @endphp
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td> {{ $no++ }} </td>
                                        <td> {{ $user->name }} </td>
                                        <td> {{ $user->email }} </td>
                                        <td> {{ $user->level->name }} </td>
                                        <td> <p class="text-{{ $user->active ? 'primary':'muted'   }}"><strong>{{ $user->active ? 'Active' : 'Inactive' }}</strong></p> </td>
                                        <td width="5%">
                                            <button type="button" data-toggle="modal" data-target="#detail{{ $user->id }}" class="btn btn-primary btn-default tombol"><i class="fas fa-info"></i></button>
                                        </td>
                                        <td><form action="{{ route('admins.destroy', $user->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                            <button class="btn btn-danger btn-default tombol"
                                                onclick="return confirm('Apakah anda yakin menghapus data ini ?');">
                                                <i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div>{{ $users->links() }}</div>
        </div>
    </div>
    

    @foreach($users as $p)
<div class="modal fade" role="dialog" id="detail{{ $p->id }}">
    <div class="modal-dialog modals-default">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h4>Detail User</h4>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a class="btn btn-sm btn-primary" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Edit Data" href="{{route('admins.edit', $p->id)}}"><i class="notika-icon notika-edit"></i></a>
                    </div>
                </div>
                             
                <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col">
                            <div id="carouselId" class="carousel" data-ride="carousel">
                                @if(isset($p->pfp))
                                    <img class="card-img-top gambarmodal pfp" src="{{ asset($p->pfp) }}"
                                align="text-center">
                                @else
                                    <img class="card-img-top gambarmodal pfp" src="{{ asset('uploads/pfp/default_pfp.png') }}"
                                align="text-center">
                                @endif
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
                    <div class="row-py-2">
                        <div class="col">
                            <div class="form-group">
                                <label>E-Mail</label>
                                <input value="{{ $p->email }}" type="text" name="license_number" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="row-py-2">
                        <div class="col">
                            <div class="form-group">
                                <label>Role</label>
                                <input value="{{ $p->level->name }}" type="text" name="penalty" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>

            </div>
        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection

<style type="text/css">

.pfp{
    clip-path: circle();
    width: 200px;
    height: 200px;
    margin-left: 80px;
    margin-top: 6px;
}

</style>