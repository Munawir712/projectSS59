@extends('layouts.master')

@section('title', 'Tambah Data Penyewaan')
    
@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Data Penyewaan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/kamarkos">Penyewaan</a></li>
              <li class="breadcrumb-item active">Tambah Data Penyewaan</li>
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
            {{-- <h3 class="card-title">Form Tambah Penyewaan</h3> --}}
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
            <form action="/penyewaan" method="POST" >
                @csrf
                <div class="form-group">
                    <label>Penyewa</label>
                    <select class="form-control select2" name="penyewa" style="width: 100%;">
                        <option value="">-- Pilih Penyewa --</option>
                        @foreach ($penyewa as $item)
                            <option value="{{ $item->id }}" @selected(old('tipe_kamar'))>{{ $item->name}} - {{  $item->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Kamar Kos</label>
                    <select class="form-control select2" name="kamarkos" style="width: 100%;">
                        <option value="">-- Pilih Kamar Kos --</option>
                        @foreach ($kamarkos as $item)
                            <option value="{{ $item->id }}" @selected(old('kamarkos'))>{{ $item->no_kamar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="date" class="form-control datetimepicker-input" name="tanggal_mulai" data-target="#reservationdate"/>
                      </div>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="date" class="form-control datetimepicker-input" name="tanggal_selesai" data-target="#reservationdate"/>
                      </div>
                  </div>
                <div class="mb-3">
                  <label for="nama" class="form-label">Durasi Sewa - Bulan</label>
                  <input type="number" class="form-control" value="{{ old('durasi_sewa') }}" name="durasi_sewa" id="no_kamar" aria-describedby="emailHelp">
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
      </div>

    </section>
@endsection

