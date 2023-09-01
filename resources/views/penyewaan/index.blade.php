@extends('layouts.master')

@section('title', 'Data Penyewaan Kos')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Penyewaan Kos</h1>
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
        @if ($message = Session::get('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
            </div>
        @endif
        @if (count($penyewaanJatuhTempo) > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Penyewaan Jatuh Tempo</h3>
                </div>
                <div class="card-body">
                    <table id="example0" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Id</th>
                                <th scope="col">Id Kamar</th>
                                <th scope="col">Penyewa</th>
                                <th scope="col">Jumlah <br> Orang</th>
                                <th scope="col">Tanggal Mulai</th>
                                <th scope="col">Tanggal Selesai</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penyewaanJatuhTempo as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if (optional($item->kosan)->id != null)
                                            <a href="/kosan/{{ $item->kosan->id }}"
                                                target="blank">{{ $item->kosan->id . '-' . $item->kosan->name }}</a>
                                        @else
                                            Data kos rusak / Kos tidak ditemukan
                                        @endif
                                    </td>
                                    <td>{{ $item->penyewa->name }}</td>
                                    <td>{{ $item->jumlah_orang }}</td>
                                    <td>{{ $item->tanggal_mulai_at_dMY() }}</td>
                                    <td>{{ $item->tanggal_selesai_at_dMY() }}</td>
                                    <td>Rp. {{ number_format($item->total, 0, '', '.') }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        @if (strtotime($item->tanggal_selesai) < strtotime(now()) && $item->status == 'sedang_disewa')
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#modal-jatuh-tempo-{{ $item->id }}">
                                                Sudah Jatuh Tempo
                                            </button>
                                            <div class="modal fade" id="modal-jatuh-tempo-{{ $item->id }}">
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
                                                            <p>Penyewaan <strong>{{ $item->id }}</strong> sudah jatuh
                                                                tempo
                                                                pada {{ $item->tanggal_selesai_at_ldFY() }} </p>
                                                            <a href="/penyewaan/{{ $item->id }}"
                                                                class="bedge bedge-info">Lihat Detail</a>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Tidak</button>
                                                            <a class="btn btn-danger"
                                                                href="{{ route('penyewaan.changeStatus', ['id' => $item->id, 'status' => 'jatuh_tempo']) }}">
                                                                Jatuh Tempo
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        @else
                                            {{-- Detail Button --}}
                                            <a href="/penyewaan/{{ $item->id }}"
                                                class="btn btn-sm btn-success">View</a>
                                            {{-- Edit Button --}}
                                            <a href="/penyewaan/{{ $item->id }}/edit"
                                                class="btn btn-sm btn-warning">Edit</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                no data
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <a href="/penyewaan/create" class="btn btn-primary">Tambah Data</a>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Id</th>
                            <th scope="col">Id-Kamar</th>
                            <th scope="col">Penyewa</th>
                            <th scope="col">Jumlah <br> Orang</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penyewaan as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if (optional($item->kosan)->id != null)
                                        <a href="/kosan/{{ $item->kosan->id }}"
                                            target="blank">{{ $item->kosan->id . '-' . $item->kosan->name }}</a>
                                    @else
                                        Data kos rusak / Kos tidak ditemukan
                                    @endif
                                </td>
                                <td>{{ $item->penyewa->name }}</td>
                                <td>{{ $item->jumlah_orang }}</td>
                                <td>{{ $item->tanggal_mulai_at_dMY() }}</td>
                                <td>{{ $item->tanggal_selesai_at_dMY() }}</td>
                                <td>Rp. {{ number_format($item->total, 0, '', '.') }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    @if (strtotime($item->tanggal_selesai) < strtotime(now()) && $item->status == 'sedang_disewa')
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-jatuh-tempo-{{ $item->id }}">
                                            Sudah Jatuh Tempo
                                        </button>
                                        <div class="modal fade" id="modal-jatuh-tempo-{{ $item->id }}">
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
                                                        <p>Penyewaan <strong>{{ $item->id }}</strong> sudah jatuh tempo
                                                            pada {{ $item->tanggal_selesai_at_ldFY() }} </p>
                                                        <a href="/penyewaan/{{ $item->id }}"
                                                            class="bedge bedge-info">Lihat Detail</a>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Tidak</button>
                                                        <a class="btn btn-success"
                                                            href="{{ route('penyewaan.changeStatus', ['id' => $item->id, 'status' => 'jatuh_tempo']) }}">
                                                            Jatuh Tempo
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    @else
                                        {{-- Detail Button --}}
                                        <a href="/penyewaan/{{ $item->id }}" class="btn btn-sm btn-success">View</a>
                                        {{-- Edit Button --}}
                                        <a href="/penyewaan/{{ $item->id }}/edit"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        {{-- Delete Button --}}
                                        {{-- <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-delete-{{ $item->id }}">
                                            Hapus
                                        </button> --}}
                                        {{-- Delete Modal --}}
                                        {{-- <div class="modal fade" id="modal-delete-{{ $item->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Peringatan</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin ingin menghapus data Penyewaan
                                                            <strong>{{ $item->id }}</strong>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Tidak</button>
                                                        <form action="/penyewaan/{{ $item->id }}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div> --}}
                                    @endif
                                </td>
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

@section('js')
    <script>
        $(function() {
            $("#example0").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "bInfo": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": [{
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Include all columns except the last one
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Include all columns except the last one
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Include all columns except the last one
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Include all columns except the last one
                        }
                    },
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
