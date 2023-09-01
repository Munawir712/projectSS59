@extends('layouts.master')

@section('title', 'Update Data User')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Data User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/users">Users</a></li>
                        <li class="breadcrumb-item active">Update Data User</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content-body')
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <a href="/users" class="btn btn-primary"><i class="fas fa-angle-left right"></i></a>
            </div>
            <div class="card-body">
                <form action="/users/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                            id="nama">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Username</label>
                        <input type="text" class="form-control" value="{{ $user->username }}" name="username"
                            id="email">
                    </div>
                    <div class="mb-3">
                        <label for="PhoneNumber" class="form-label">No Hanphone </label>
                        <input type="number" class="form-control" name="phoneNumber" value="{{ $user->phone_number }}"
                            id="phoneNumber">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Jenis Kelamin</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="pria" value="pria"
                                @if ($user->jenis_kelamin == 'pria') checked @endif name="jenis_kelamin">
                            <label for="pria" class="custom-control-label">Pria</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="wanita" value="wanita"
                                @if ($user->jenis_kelamin == 'wanita') checked @endif name="jenis_kelamin">
                            <label for="wanita" class="custom-control-label">Wanita</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Foto KTP</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="foto_ktp" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </section>
@endsection
@section('js')
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
