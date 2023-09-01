@extends('layouts.master')

@section('title', 'Detail Penyewaan')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Penyewaan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">detail penyewaan</li>
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
            <div class="card-header d-flex">
                <div class="p-3">
                    <a href="/penyewaan" class="btn btn-primary"><i class="fas fa-angle-left right"></i></a>
                </div>
                <!-- <a href="/penyewaan/create" class="btn btn-primary">Tambah Data</a> -->
                <div class="ml-auto p-3 ">
                    <a href="/penyewaan/{{ $penyewaan->id }}/edit" class="btn btn-warning mr-2"><i
                            class="fas fa-pen"></i></a>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                        data-target="#modal-delete-{{ $penyewaan->id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                    {{-- Modal --}}
                    <div class="modal fade" id="modal-delete-{{ $penyewaan->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Peringatan</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin ingin menghapus data penyewaan
                                        <strong>{{ $penyewaan->id }}</strong>
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                    <form action="/penyewaan/{{ $penyewaan->id }}" method="POST">
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
            <div class="card-body">
                <div class="card mb-3">
                    <div class="row g-0 px-3 d-flex align-items-center">
                        <div class="col-md-2">
                            @if (optional($penyewaan->kosan)->kosanImage == null)
                                <img src="../../dist/img/default-150x150.png" class="img-fluid rounded-start"
                                    alt="...">
                            @else
                                <img src="{{ url('') }}/{{ $penyewaan->kosan->kosanImage[0]->image_url }}"
                                    class="img-fluid rounded-start" alt="...">
                            @endif
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5>Kost</h5>
                                <div class="row mb-2">
                                    <span class="border border-1 col-md border-dark"></span>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <h6>Nama Kos</h6>
                                        <p>{{ optional($penyewaan->kosan)->name ?? 'Kos tidak ditemukan' }}</p>
                                    </div>
                                    <div class="col-md">
                                        <h6>Lama Sewa</h6>
                                        <p>{{ $penyewaan->durasi_sewa }} Bulan</p>
                                    </div>
                                    <div class="col-md">
                                        <h6>Tanggal Mulai</h6>
                                        <p>{{ $penyewaan->tanggal_mulai }}</p>
                                    </div>
                                    <div class="col-md">
                                        <h6>Tanggal Selesai</h6>
                                        <p>{{ $penyewaan->tanggal_selesai }}</p>
                                    </div>
                                </div>
                                <h5>Penyewa</h5>
                                <div class="row mb-2">
                                    <span class="border border-1 col-md border-dark"></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6>Nama Penyewa</h6>
                                        <p>{{ $penyewaan->penyewa->name }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Nomor Handphone</h6>
                                        <p>{{ $penyewaan->penyewa->phone_number }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <span class="border border-1 col-md border-dark"></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6>Harga Per bulan</h6>
                                        <p>Rp. {{ number_format(optional($penyewaan->kosan)->harga ?? 0, 0, '', '.') }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Total Harga</h6>
                                        <p>Rp. {{ number_format($penyewaan->total, 0, '', '.') }}</p>
                                    </div>

                                    <div class="col-md">
                                        <h6>Status</h6>
                                        @if (strtotime($penyewaan->tanggal_selesai) < strtotime(now()) && $penyewaan->status == 'sedang_disewa')
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#modal-jatuh-tempo-{{ $penyewaan->id }}">
                                                Penyewaan Sudah Jatuh Tempo
                                            </button>
                                            <div class="modal fade" id="modal-jatuh-tempo-{{ $penyewaan->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Konfirmasi Selesai Penyewaan</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Penyewaan <strong>{{ $penyewaan->id }}</strong> sudah jatuh
                                                                tempo
                                                                pada {{ $penyewaan->tanggal_selesai_at_ldFY() }} </p>
                                                            <a href="/penyewaan/{{ $penyewaan->id }}"
                                                                class="bedge bedge-info">Lihat Detail</a>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Tidak</button>
                                                            <a class="btn btn-success"
                                                                href="{{ route('penyewaan.changeStatus', ['id' => $penyewaan->id, 'status' => 'selesai']) }}">
                                                                Selesai
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        @else
                                            @switch($penyewaan->status)
                                                @case('dikonfirmasi')
                                                    <a href="#" class="btn btn-sm btn-primary">Dikonfirmasi</a>
                                                @break

                                                @case('selesai')
                                                    <a href="#" class="btn btn-sm btn-success">Selesai</a>
                                                @break

                                                @case('sedang_disewa')
                                                    <a href="#" class="btn btn-sm btn-info">Sedang Disewa</a>
                                                @break

                                                @case('dibatalkan')
                                                    <a href="#" class="btn btn-sm btn-danger">Dibatalkan</a>
                                                @break

                                                @case('jatuh_tempo')
                                                    <a href="#" class="btn btn-sm btn-danger">Jatuh Tempo</a>
                                                @break

                                                @default
                                                    <a href="#" class="btn btn-sm btn-secondary"> Belum Dikonfirmasi</a>
                                            @endswitch
                                        @endif

                                    </div>
                                    <div class="col-md ">
                                        <h6>Ganti Status</h6>
                                        <a href="{{ route('penyewaan.changeStatus', ['id' => $penyewaan->id, 'status' => 'dikonfirmasi']) }}"
                                            class="btn-sm d-block btn-primary mb-2">Konfirmasi</a>
                                        <a href="{{ route('penyewaan.changeStatus', ['id' => $penyewaan->id, 'status' => 'selesai']) }}"
                                            class="btn-sm d-block btn-success mb-2">Selesai</a>
                                        <a href="{{ route('penyewaan.changeStatus', ['id' => $penyewaan->id, 'status' => 'sedang_disewa']) }}"
                                            class="btn-sm d-block btn-info mb-2">Sedang Disewa</a>
                                        <a href="{{ route('penyewaan.changeStatus', ['id' => $penyewaan->id, 'status' => 'dibatalkan']) }}"
                                            class="btn-sm d-block btn-secondary  mb-2">Dibatalkan</a>
                                        <a href="{{ route('penyewaan.changeStatus', ['id' => $penyewaan->id, 'status' => 'belum_dikonfirmasi']) }}"
                                            class="btn-sm d-block btn-warning mb-2"> Belum
                                            Dikonfirmasi</a>
                                        <a href="{{ route('penyewaan.changeStatus', ['id' => $penyewaan->id, 'status' => 'jatuh_tempo']) }}"
                                            class="btn-sm d-block btn-danger mb-2">Jatuh Tempo</a>
                                    </div>
                                </div>
                                <p class="card-text">
                                    <small class="text-muted">{{ $penyewaan->createAtDiffForHumans() }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
