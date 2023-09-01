@extends('layouts.master')

@section('title', 'Tambah Data Kosan')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Data Kosan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/kamarkos">Kosan</a></li>
                        <li class="breadcrumb-item active">Tambah Data Kosan</li>
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
                <a href="/kosan" class="btn btn-primary"><i class="fas fa-angle-left right"></i></a>
            </div>
            <div class="card-body">
                <form action="/kosan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputFile">Gambar</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="images[]" multiple class="custom-file-input"
                                    id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">No Kamar</label>
                        <input type="text" class="form-control" value="{{ old('no_kamar') }}" name="no_kamar"
                            id="no_kamar" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="nama"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" value="{{ old('alamat') }}" name="alamat" id="alamat"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Kategori Jenis Kelamin</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="pria" value="PUTRA"
                                name="gender_category">
                            <label for="pria" class="custom-control-label">Pria</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="wanita" value="PUTRI"
                                name="gender_category">
                            <label for="wanita" class="custom-control-label">Wanita</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="campuran" value="CAMPURAN"
                                name="gender_category">
                            <label for="campuran" class="custom-control-label">Campuran</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="max_orang" class="form-label">Maks Orang</label>
                        <input type="number" class="form-control" value="{{ old('max_orang') }}" name="max_orang"
                            id="max_orang" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <select class="form-control select2" name="tipe" id="tipe" style="width: 100%;">
                            <option>-- Pilih Tipe --</option>
                            <option value="KAMAR" @selected(old('tipe') == 'KAMAR')>Kamar</option>
                            <option value="RUMAH" @selected(old('tipe') == 'RUMAH')>Rumah</option>
                        </select>
                    </div>
                    <div class="form-group" id="jumlah-kamar-group" style="display: none;">
                        <label>Jumlah Kamar</label>
                        <input type="number" class="form-control" value="1" name="jumlah_kos" id="jumlah-kamar">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control select2" name="category" style="width: 100%;">
                            <option>-- Pilih Kategori --</option>
                            @foreach ($category as $item)
                                <option value="{{ $item }}" @selected(old('category') == $item)>{{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="max_orang" class="form-label">Pilih Fasilitas</label>
                        @foreach ($facilities as $item)
                            <div class="form-check">
                                <input class="form-check-input" name="facilities[]" type="checkbox"
                                    value="{{ $item->slug }}" id="{{ $item->slug }}flexCheckDefault">
                                <label class="form-check-label" for="{{ $item->slug }}flexCheckDefault">
                                    {{ $item->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- <div class="form-group">
                        <label>Fasilitas</label>
                        <select class="select2bs4" name="facilities[]" multiple="multiple"
                            data-placeholder="Pilih fasilitas" style="width: 100%;">
                            @foreach ($facilities as $item)
                                <option value="{{ $item->slug }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga / Bulan</label>
                        <input type="number" class="form-control" value="{{ old('harga') }}" name="harga"
                            id="harga">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Deskripsi
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <textarea id="summernote" name="description">
                                      {{ old('description') }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </section>

@endsection
@section('js')
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function() {
            $('#summernote').summernote()
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $('#tipe').on('change', function() {
                if ($(this).val() === 'KAMAR') {
                    $('#jumlah-kamar-group').show();
                } else {
                    $('#jumlah-kamar-group').hide();
                    $('#jumlah-kamar').val(1);
                }
            });
        });
    </script>
@endsection
