@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="min-height: 85vh">
                <div class="card-header bg-white">
                    <form action="" method="get">
                        <div class="row">  
                            <div class="col"><h4 class="font-weight-bold">Pengguna</h4></div>
                            <div class="col"><input type="text" name="search"
                                    class="form-control form-control-sm col-sm-10 float-right"
                                    placeholder="Search User..." onblur="this.form.submit()"></div>
                            <div class="col-sm-2"><a href=""
                                    class="btn btn-primary btn-sm float-right btn-block">Tambah Pengguna</a></div>
                        </div>
                    </form>
                <div class="card-body">
                    @if(Session::has('success'))
                    @include('layouts.flash-success',[ 'message'=> Session('success') ])
                    @endif
                    <table class="table table-sm">
                        @php $no = 1; @endphp
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td> {{ $no++ }} </td>
                                <td> {{ $user->name }} </td>
                                <td> {{ $user->email }} </td>
                                <td> {{ $user->level->name }} </td>
                                <td> <p class="badge badge-{{ $user->active ? 'success':'danger'   }}">{{ $user->active ? 'Active' : 'Inactive' }}</p> </td>
                                <td><form action="">
                                        <button class="btn btn-primary btn-sm float-right">Detail</button>
                                    </form>
                                </td>
                                <td><form action="" method="POST">
                                        @method('delete')
                                        @csrf
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah anda yakin menghapus data ini ?');">Hapus Pengguna</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach                        
                    </table>
                </div>
            </div>
        <div>{{ $users->links() }}</div>
    </div>
</div>
</div>
</div>
    
@endsection
