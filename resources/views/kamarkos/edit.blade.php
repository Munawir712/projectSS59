@extends('layouts.master')

@section('title', 'Edit Data Kamar Kos')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Kamar Kos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/kamarkos">Kamar Kos</a></li>
                        <li class="breadcrumb-item active">Edit Data Kamar Kos</li>
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
                <form action="/kosan/{{ $kamarkos->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                        <input type="text" class="form-control" value="{{ old('no_kamar') ?? $kamarkos->no_kamar }}"
                            name="no_kamar" id="no_kamar" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ old('name') ?? $kamarkos->name }}"
                            name="name" id="nama" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" value="{{ old('alamat') ?? $kamarkos->alamat }}"
                            name="alamat" id="alamat" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Kategori Jenis Kelamin</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="pria" value="PUTRA"
                                @if ($kamarkos->gender_category == 'PUTRA') checked @endif name="gender_category">
                            <label for="pria" class="custom-control-label">Putra</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="wanita" value="PUTRI"
                                @if ($kamarkos->gender_category == 'PUTRI') checked @endif name="gender_category">
                            <label for="wanita" class="custom-control-label">Putri</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="campuran" value="CAMPURAN"
                                @if ($kamarkos->gender_category == 'CAMPURAN') checked @endif name="gender_category">
                            <label for="campuran" class="custom-control-label">Campuran</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="max_orang" class="form-label">Maks Orang</label>
                        <input type="number" class="form-control" value="{{ old('max_orang', $kamarkos->max_orang) }}"
                            name="max_orang" id="max_orang" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <select class="form-control select2" id="tipe" name="tipe" style="width: 100%;">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="KAMAR" @selected(old('tipe') ?? $kamarkos->tipe == 'KAMAR')>Kamar</option>
                            <option value="RUMAH" @selected(old('tipe') ?? $kamarkos->tipe == 'RUMAH')>Rumah</option>
                        </select>
                    </div>
                    <div class="form-group" id="jumlah-kamar-group"
                        style="display: {{ $kamarkos->tipe == 'KAMAR' ? '' : 'none' }};">
                        <label>Jumlah Kamar</label>
                        <input type="number" class="form-control" value="{{ $kamarkos->jumlah_kos }}" name="jumlah_kos"
                            id="jumlah-kamar">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control select2" name="category" style="width: 100%;">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($category as $item)
                                <option value="{{ $item }}" @selected(old('category') ?? strtolower($kamarkos->category) == $item)>{{ ucfirst($item) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="max_orang" class="form-label">Pilih Fasilitas</label>
                        @php
                            $kamarkosFacilities = $kamarkos->facilities->pluck('slug')->toArray();
                        @endphp
                        @foreach ($facilities as $item)
                            @php
                                $checked = in_array($item->slug, $kamarkosFacilities);
                            @endphp
                            <div class="form-check ">
                                <input class="form-check-input" name="facilities[]" type="checkbox"
                                    value="{{ $item->slug }}" {{ $checked ? 'checked' : '' }}
                                    id="{{ $item->slug }}flexCheckDefault">
                                <label class="form-check-label" for="{{ $item->slug }}flexCheckDefault">
                                    {{ $item->name }}
                                </label>
                            </div>
                        @endforeach

                    </div>
                    <div class="mb-3">
                        <label for="PhoneNumber" class="form-label">Harga / Bulan</label>
                        <input type="number" class="form-control" value="{{ old('harga') ?? $kamarkos->harga }}"
                            name="harga" id="harga">
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
                                      {{ old('description') ?? $kamarkos->description }}
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
    <script>
        $(function() {
            $('#summernote').summernote()
            bsCustomFileInput.init();

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
