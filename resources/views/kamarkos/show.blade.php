@extends('layouts.master')

@section('title', 'Detail Kosan')

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Kosan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Detail Kos</li>
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
            <div class="card-header d-flex p-0">
                <div class="p-3">
                    <a href="/kosan" class="btn btn-primary"><i class="fas fa-angle-left right"></i></a>
                    <strong class="ml-2">{{ $kosan->id }}-{{ $kosan->name }}</strong>
                </div>
                <div class="ml-auto p-3">
                    <div class="row">
                        <a href="/kosan/{{ $kosan->id }}/edit" class="btn btn-warning mr-2"><i
                                class="fas fa-pen"></i></a>
                        <form action="/kosan/{{ $kosan->id }}" method="POST">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="card-title">Gambar</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($kosan->kosanImage as $item)
                                <div class="col-sm-3" style="max-height: 40%;">
                                    <a href="{{ url('') }}/{{ $item->image_url }}" data-toggle="lightbox"
                                        data-title="{{ $item->filename }}" data-gallery="gallery">
                                        <img src="{{ url('') }}/{{ $item->image_url }}" class="img-fluid mb-2"
                                            alt="white sample" />
                                    </a>
                                </div>
                            @empty
                                <h6>No Image</h6>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card  mb-3">
                    <div class="card-header">
                        <h4 class="card-title">Data kos</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-0 px-2 d-flex align-items-center">
                            <div class="col-md">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md">
                                            <strong>Id Kos</strong>
                                            <p>{{ $kosan->id }}</p>
                                        </div>
                                        <div class="col-md">
                                            <strong>Nama Kos</strong>
                                            <p>{{ $kosan->name }}</p>
                                        </div>
                                        <div class="col-md">
                                            <strong>No Kamar</strong>
                                            <p>{{ $kosan->no_kamar }}</p>
                                        </div>
                                        <div class="col-md">
                                            <strong>Tipe Kos</strong>
                                            <p>{{ $kosan->tipe }}</p>
                                        </div>

                                    </div>
                                    <div class="row mb-2">
                                        @if ($kosan->tipe == 'KAMAR')
                                            <div class="col-md">
                                                <strong>Jumlah Kamar kos</strong>
                                                <p>{{ $kosan->jumlah_kos }}</p>
                                            </div>
                                        @endif
                                        <div class="col-md">
                                            <strong>Kategori Jenis Kelamin</strong>
                                            <p>{{ $kosan->gender_category }}</p>
                                        </div>
                                        <div class="col-md">
                                            <strong>Maks Orang</strong>
                                            <p>{{ $kosan->max_orang }}</p>
                                        </div>
                                        <div class="col-md">
                                            <strong>Harga Perbulan</strong>
                                            <p>{{ number_format($kosan->harga, 0, '', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <strong>Deskripsi</strong>
                                            <p>{!! $kosan->description !!}</p>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>Fasilitas</strong>
                                            <div class="row">
                                                @forelse ($kosan->facilities as $item)
                                                    <div class="col-md-3 mb-2">
                                                        <div class="btn btn-block  btn-success">
                                                            {{ $item->name }}
                                                        </div>
                                                    </div>
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')
    <script src="../../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script src="../../plugins/filterizr/jquery.filterizr.min.js"></script>
    <script>
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.filter-container').filterizr({
                gutterPixels: 3
            });
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>
@endsection
