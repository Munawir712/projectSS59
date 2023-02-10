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
            {{-- <h3 class="card-title">Form Edit Kamar Kos</h3> --}}
            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
            </div>
        </div>
        <div class="card-body">
            <form action="/kamarkos/{{ $kamarkos->id }}" method="POST" >
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label for="nama" class="form-label">No Kamar</label>
                  <input type="text" class="form-control" value="{{ old('no_kamar') ?? $kamarkos->no_kamar }}" name="no_kamar" id="no_kamar" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" class="form-control" value="{{ old('name') ?? $kamarkos->name }}" name="name" id="nama" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label>Tipe</label>
                    <select class="form-control select2" name="tipe_kamar" style="width: 100%;">
                        <option value="">-- Pilih Tipe --</option>
                        @foreach ($tipe_kamar as $item)
                            <option value="{{ $item }}" @selected(old('tipe_kamar') ?? $kamarkos->tipe)>{{ $item }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="mb-3">
                  <label for="PhoneNumber" class="form-label">Harga</label>
                  <input type="number" class="form-control" value="{{ old('harga') ?? $kamarkos->harga }}" name="harga" id="harga">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
      </div>

    </section>
@endsection

