@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="normal-table-area">
        <div class="container">
            @if(Session::has('success'))
            @include('layouts.flash-success',[ 'message'=> Session('success') ])
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list">
                        <div class="basic-tb-hd">
                            <form action="{{ route('kategori.index') }}" method="get">
                                <div class="row">  
                                    <div class="nk-int-st search-input search-overt col"><input type="text" name="search"
                                            class="form-control form-control-sm col-sm-10 float-right"
                                            placeholder="Search Kategori..." onblur="this.form.submit()">
                                    <button class="btn search-ib submit">Search</button>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="col"><a href="{{route('kategori.create')}}"
                                    class="btn btn-success btn-sm float-right btn-block">Tambah Kategori</a></div>
                                </div>
                            </form>
                            <!-- <h2>Basic Table</h2>
                            <p>Basic example without any additional modification classes</p> -->
                        </div>
                        <div class="bsc-tbl">
                            <table class="table table-sc-ex">
                                <thead>
                                    @php $no = 1; @endphp
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        @foreach ($kategori as $mrk)
                            <tr>
                                <td> {{ $no++ }} </td>
                                <td> {{ $mrk->name }} </td>

                                <td><form action="{{ route('kategori.destroy', $mrk->id) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah anda yakin menghapus data ini ?');">Hapus</button>
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
        </div>
    </div>
@endsection