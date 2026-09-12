@extends('layouts.app')
@section('title', 'Tambah Foto Galeri')

@section('content')
<main class="kotak" style="margin-top: 120px;">
    <h1>Tambah Foto Kegiatan</h1>

    @if ($errors->any())
        <div style="color:red; margin-bottom:15px; border: 1px solid red; padding:10px; background-color:#fdd;">
            <ul style="margin:0;">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="judul">Keterangan:</label>
        <input type="text" id="judul" name="judul" required style="width: 75%; padding: 10px; margin-bottom: 15px;" value="{{ old('judul') }}">
        <br>
        <label for="foto">Pilih Foto:</label>
        <input type="file" id="foto" name="foto" required style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <br><br>
        <input type="submit" value="Simpan Foto" class="btn-tampilkan">
        <a href="{{ route('galeri.index') }}" style="margin-left: 15px; color: #d9534f; text-decoration: none;">Batal</a>
    </form>
</main>
@endsection