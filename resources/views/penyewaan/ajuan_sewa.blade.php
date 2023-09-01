@extends('layouts.master')

@section('title', 'Data Ajuan sewa Kos')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Ajuan sewa Kos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">penyewaan</li>
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
                <!-- <a href="/penyewaan/create" class="btn btn-primary">Tambah Data</a> -->
            </div>
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Id Kamar</th>
                            <th scope="col">Penyewa</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penyewaan as $item)
                            <div class="card mb-3">
                                <div class="row g-0 px-2 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <h6><strong>Id Penyewaan</strong>: {{ $item->id }} </h6>
                                        @if ($item->kosan->kosanImage->isEmpty())
                                            <img src="../../dist/img/default-150x150.png" class="img-fluid rounded-start"
                                                alt="...">
                                        @else
                                            <img src="{{ url('') }}/{{ $item->kosan->kosanImage[0]->image_url }}"
                                                class="img-fluid rounded-start" alt="...">
                                        @endif
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md">
                                                    <h6>Nama Kos</h6>
                                                    <p>{{ $item->kosan->name }}</p>
                                                </div>
                                                <div class="col-md">
                                                    <h6>Lama Sewa</h6>
                                                    <p>{{ $item->durasi_sewa }} Bulan</p>
                                                </div>
                                                <div class="col-md">
                                                    <h6>Tanggal Mulai</h6>
                                                    <p>{{ $item->tanggal_mulai }}</p>
                                                </div>
                                                <div class="col-md">
                                                    <h6>Tanggal Selesai</h6>
                                                    <p>{{ $item->tanggal_selesai }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h6>Nama Penyewa</h6>
                                                    <p>{{ $item->penyewa->name }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <h6>Nomor Handphone</h6>
                                                    <p>{{ $item->penyewa->phone_number }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <h6>Total</h6>
                                                    <p>Rp. {{ number_format($item->total, 0, '', '.') }}</p>
                                                </div>

                                                <div class="col-md">
                                                    <a href="{{ route('penyewaan.changeStatus', ['id' => $item->id, 'status' => 'dikonfirmasi']) }}"
                                                        class="btn btn-primary">Konfirmasi</a>
                                                    {{-- <a href="{{ route('penyewaan.changeStatus', ['id' => $item->id, 'status' => 'selesai']) }}"
                                                        class="btn btn-success">Selesai</a> --}}
                                                    <a href="{{ route('penyewaan.changeStatus', ['id' => $item->id, 'status' => 'dibatalkan']) }}"
                                                        class="btn btn-outline-danger">Batalkan</a>

                                                </div>
                                            </div>
                                            <div class="row mx-auto d-flex justify-content-between">
                                                <p class="card-text"><small
                                                        class="text-muted">{{ $item->createAtDiffForHumans() }}</small>
                                                </p>
                                                <a href="/penyewaan/{{ $item->id }}">Lihat Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->kosan->id }}</td>
                                <td>{{ $item->penyewa->name }}</td>
                                <td>{{ $item->tanggal_mulai }}</td>
                                <td>{{ $item->tanggal_selesai }}</td>
                                <td>Rp. {{ number_format($item->total, 0, '', '.') }}</td>
                                <td>{{ $item->status }}</td>

                            </tr>
                        @empty
                            No
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
