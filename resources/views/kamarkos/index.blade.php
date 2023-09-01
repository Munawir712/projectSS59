@extends('layouts.master')

@section('title', 'Data Kamar Kos')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Kost</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Kost</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content-body')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @if ($message = Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="/kosan/create" class="btn btn-primary">Tambah Data</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No Kamar </th>
                                        <th>Nama</th>
                                        <th>Tipe</th>
                                        <th>Kategori Jenis Kelamin </th>
                                        <th>Maks Orang</th>
                                        <th>Harga/Bulan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kamarkos as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $item->no_kamar }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->tipe }}</td>
                                            <td>{{ $item->gender_category }}</td>
                                            <td>{{ $item->max_orang }}</td>
                                            <td>{{ number_format($item->harga, 0, '', '.') }}</td>
                                            <td>
                                                <a href="/kosan/{{ $item->id }}" class="btn btn-sm btn-success">View</a>
                                                <a href="/kosan/{{ $item->id }}/edit"
                                                    class="btn btn-sm btn-warning">Edit</a>
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
                                                                <p>Apakah anda yakin ingin menghapus data Kamar
                                                                    <strong>{{ $item->no_kamar }} - {{ $item->name }}
                                                                    </strong>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Tidak</button>
                                                                <form action="/kosan/{{ $item->id }}" method="POST">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
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
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>No Kamar </th>
                                        <th>Nama</th>
                                        <th>Tipe</th>
                                        <th>Kategori Jenis Kelamin </th>
                                        <th>Maks Orang</th>
                                        <th>Harga/Bulan</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
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
                "autoWidth": true,
                "buttons": ["csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
