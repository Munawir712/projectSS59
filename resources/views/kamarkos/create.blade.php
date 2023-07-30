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
      <form action="/kosan" method="POST">
        @csrf
        <div class="mb-3">
          <label for="nama" class="form-label">No Kamar</label>
          <input type="text" class="form-control" value="{{ old('no_kamar') }}" name="no_kamar" id="no_kamar" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="nama" class="form-label">Nama</label>
          <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="nama" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <input type="text" class="form-control" value="{{ old('alamat') }}" name="alamat" id="alamat" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="exampleInputFile">Kategori Jenis Kelamin</label>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="pria" value="PUTRA" name="gender_category">
            <label for="pria" class="custom-control-label">Pria</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="wanita" value="PUTRI" name="gender_category">
            <label for="wanita" class="custom-control-label">Wanita</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="campuran" value="CAMPURAN" name="gender_category">
            <label for="campuran" class="custom-control-label">Campuran</label>
          </div>
        </div>
        <div class="mb-3">
          <label for="max_orang" class="form-label">Maks Orang</label>
          <input type="number" class="form-control" value="{{ old('max_orang') }}" name="max_orang" id="max_orang" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label>Tipe</label>
          <select class="form-control select2" name="category" style="width: 100%;">
            <option value="">-- Pilih Tipe --</option>
            @foreach ($category as $item)
            <option value="{{ $item }}" @selected(old('category'))>{{ $item }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="harga" class="form-label">Harga</label>
          <input type="number" class="form-control" value="{{ old('harga') }}" name="harga" id="harga">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

</section>
@endsection