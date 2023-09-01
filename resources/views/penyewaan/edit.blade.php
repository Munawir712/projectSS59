@extends('layouts.master')

@section('title', 'Edit Data Penyewaan')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Penyewaan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/kamarkos">Penyewaan</a></li>
                        <li class="breadcrumb-item active">Edit Data Penyewaan</li>
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
                <a href="/penyewaan" class="btn btn-primary"><i class="fas fa-angle-left right"></i></a>
            </div>
            <div class="card-body">
                <form action="/penyewaan/{{ $penyewaan->id }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>Penyewa</label>
                        <select class="form-control select2 @error('penyewa') is-invalid @enderror" name="penyewa"
                            style="width: 100%;">
                            <option value="">-- Pilih Penyewa --</option>
                            @foreach ($penyewa as $item)
                                <option value="{{ $item->id }}" @selected(old('penyewa', strtolower($item->id) == $penyewaan->penyewa_id))>{{ $item->name }} -
                                    {{ $item->email }}</option>
                            @endforeach
                        </select>
                        @error('penyewa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Kosan</label>
                        <select class="form-control select2 @error('kosan') is-invalid @enderror" name="kosan_id"
                            style="width: 100%;">
                            <option value="">-- Pilih Kamar Kos --</option>
                            @foreach ($kosan as $item)
                                <option value="{{ $item->id }}" @selected(old('kosan', strtolower($item->id) == $penyewaan->kosan_id))>{{ $item->no_kamar }} -
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('kosan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="date" value="{{ old('tanggal_mulai', $penyewaan->tanggal_mulai) }}"
                                class="form-control datetimepicker-input @error('tanggal_mulai') is-invalid @enderror"
                                name="tanggal_mulai" data-target="#reservationdate" />
                        </div>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                        <input type="number" class="form-control @error('jumlah_orang') is-invalid @enderror"
                            value="{{ old('jumlah_orang', $penyewaan->jumlah_orang) }}" name="jumlah_orang"
                            id="jumlah_orang" aria-describedby="emailHelp">
                        @error('jumlah_orang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="durasi_sewa" class="form-label">Durasi Sewa - Bulan</label>
                        <input type="number" class="form-control @error('durasi_sewa') is-invalid @enderror"
                            value="{{ old('durasi_sewa', $penyewaan->durasi_sewa) }}" name="durasi_sewa" id="no_kamar"
                            aria-describedby="emailHelp">
                        @error('durasi_sewa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control select2 @error('kosan') is-invalid @enderror" name="status"
                            style="width: 100%;">
                            @foreach ($status as $item)
                                <option value="{{ $item }}" @selected(old('status', $item == $penyewaan->status))>{{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>

    </section>
@endsection
