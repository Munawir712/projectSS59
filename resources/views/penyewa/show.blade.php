@extends('layouts.master')

@section('title', 'Data Ajuan sewa Kos')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Penyewa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Detail penyewa</li>
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
                <div class="row">
                    <div class="p-3">
                        <a href="/penyewa" class="btn btn-primary"><i class="fas fa-angle-left right"></i></a>
                    </div>
                    <div class="ml-auto p-3 d-flex">
                        <a href="/penyewa/{{ $penyewa->id }}/edit" class="btn btn-warning mr-2"><i
                                class="fas fa-pen"></i></a>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                            data-target="#modal-delete-{{ $penyewa->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        {{-- Modal --}}
                        <div class="modal fade" id="modal-delete-{{ $penyewa->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Peringatan</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda yakin ingin menghapus data penyewa
                                            <strong>{{ $penyewa->name }}</strong>
                                        </p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                        <form action="/penyewa/{{ $penyewa->id }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card mb-3">
                    <div class="row g-0 px-2 d-flex align-items-center">
                        <div class="col-md-10">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md">
                                        <strong>Nama</strong>
                                        <p>{{ $penyewa->name }}</p>
                                    </div>
                                    <div class="col-md">
                                        <strong>Username</strong>
                                        <p>{{ $penyewa->username }} Bulan</p>
                                    </div>
                                    <div class="col-md">
                                        <strong>Nomor Handphone</strong>
                                        <p>{{ $penyewa->phone_number }}</p>
                                    </div>
                                    <div class="col-md">
                                        <strong>Jenis Kelamin</strong>
                                        <p>{{ $penyewa->jenis_kelamin }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 pb-4 pt-3 text-center">
                            <strong>Foto KTP</strong>
                            @if ($penyewa->foto_ktp == '')
                                <img src="../../dist/img/default-150x150.png" class="img-fluid rounded-start"
                                    alt="...">
                            @else
                                <a href="{{ url('') }}/{{ $penyewa->foto_ktp }}" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="{{ url('') }}/{{ $penyewa->foto_ktp }}"
                                        class="img-fluid rounded-start" alt="...">
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
