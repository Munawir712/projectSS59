@extends('layouts.master')

@section('title', 'Data Penyewa')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Penyewa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Penyewa</li>
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
        <div class="card">
            <div class="card-header">
                <a href="/penyewa/create" class="btn btn-primary">Tambah Data</a>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">No Hanphone</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">KTP</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penyewa as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone_number }}</td>
                                <td>{{ $item->jenis_kelamin }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                        data-target="#modal-viewKtp-{{ $item->id }}">
                                        View KTP
                                    </button>
                                    {{-- Modal --}}
                                    <div class="modal fade" id="modal-viewKtp-{{ $item->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">KTP - {{ $item->name }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card mb-3 p-3">
                                                        @if ($item->foto_ktp == '')
                                                            <h5 class="text-center">Gambar Rusak / Tidak ditemukan</h5>
                                                        @else
                                                            <img src="{{ url('') }}/{{ $item->foto_ktp }}"
                                                                class="card-img-top" alt="...">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </td>
                                <td>
                                    <a href="penyewa/{{ $item->id }}" class="btn btn-sm btn-success">View</a>
                                    <a href="penyewa/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#modal-delete-{{ $item->id }}">
                                        Hapus
                                    </button>
                                    {{-- Modal --}}
                                    <div class="modal fade" id="modal-delete-{{ $item->id }}">
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
                                                    <p>Apakah anda yakin ingin menghapus data penyewa
                                                        <strong>{{ $item->name }}</strong>
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Tidak</button>
                                                    <form action="/penyewa/{{ $item->id }}" method="POST">
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
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,

                "buttons": [{
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Include all columns except the last one
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Include all columns except the last one
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Include all columns except the last one
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Include all columns except the last one
                        }
                    },
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
