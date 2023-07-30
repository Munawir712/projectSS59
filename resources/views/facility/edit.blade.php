@extends('layouts.master')

@section('title', 'Edit Data Fasilitas')

@section('content-header')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Data Fasilitas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/kamarkos">Fasilitas</a></li>
                    <li class="breadcrumb-item active">Edit Data Fasilitas</li>
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
            <a href="/facility" class="btn btn-primary"><i class="fas fa-angle-left right"></i></a>
        </div>
        <div class="card-body">
            <form action="/facility/{{ $facility->id }}" method="POST">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name', $facility->name) }}" name="name" id="name" aria-describedby="emailHelp">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control  @error('slug') is-invalid @enderror" value="{{ old('slug', $facility->slug) }}" name="slug" id="slug" aria-describedby="emailHelp">
                    @error('slug')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="desc" class="form-label">Deskirpsi</label>
                    <input type="text" class="form-control" value="{{ old('desc', $facility->desc) }}" name="desc" id="desc" aria-describedby="emailHelp">
                    @error('desc')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</section>
<script>
    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');

    name.addEventListener('change', function() {
        fetch('/facility/checkSlug?name=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    });
</script>
@endsection