@extends('layouts.master')

@section('title', 'Tambah Data Penyewa')
    
@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Data Penyewa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/penyewa">Penyewa</a></li>
              <li class="breadcrumb-item active">Tambah Data Pemyewa</li>
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
            <h3 class="card-title">Form Tambah Penyewa</h3>
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
            <form action="/penyewa" method="POST" >
                @csrf
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" class="form-control" name="name" id="nama" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                  <label for="PhoneNumber" class="form-label">No Hp </label>
                  <input type="number" class="form-control" name="phoneNumber" id="phoneNumber" name="phoneNumber">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Jenis Kelamin</label>
                    <div class="d-block">
                      <div class="custom-control custom-radio d-inline">
                        <input class="custom-control-input" type="radio" id="pria" value="pria" name="jenis_kelamin">
                        <label for="pria" class="custom-control-label">Pria</label>
                    </div>
                    <div class="custom-control custom-radio d-inline">
                        <input class="custom-control-input" type="radio" id="wanita" value="wanita" name="jenis_kelamin">
                        <label for="wanita" class="custom-control-label">Wanita</label>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Foto KTP</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                    </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
      </div>

    </section>
@endsection

