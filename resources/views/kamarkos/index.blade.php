@extends('layouts.master')

@section('title', 'Data Kamar Kos')

@section('content-header')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Kamar Kos</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Kamarkos</li>
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
      <a href="/kosan/create" class="btn btn-primary">Tambah Data</a>
    </div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">No Kamar</th>
            <th scope="col">Nama</th>
            <th scope="col">Tipe</th>
            <th scope="col">Kategori Jenis Kelamin</th>
            <th scope="col">Maks Orang</th>
            <th scope="col">Harga/Bulan</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($kamarkos as $item)
          <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{ $item->no_kamar }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->tipe }}</td>
            <td>{{ $item->gender_category }}</td>
            <td>{{ $item->max_orang }}</td>
            <td> {{ $item->harga }} </td>
            <td>
              <a href="/kosan/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $item->id }}">
                Hapus
              </button>
              {{-- Modal --}}
              <div class="modal fade" id="modal-delete-{{ $item->id }}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Peringatan</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Apakah anda yakin ingin menghapus data Kamar <strong>{{ $item->no_kamar }}</strong> </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                      <form action="/kamarkos/{{ $item->id }}" method="POST">
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