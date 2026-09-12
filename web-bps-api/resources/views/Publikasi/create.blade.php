@extends('layouts.app')
@section('title', 'Tambah Publikasi')

@section('content')
<main class="kotak" style="margin-top: 100px;">
    <h1>Form Penambahan Publikasi Baru</h1>

    @if ($errors->any())
        <div style="color:red; background-color:#fdd; padding:10px; border:1px solid red; margin-bottom:15px;">
            <ul style="margin:0;">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('publikasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" style="width: 75%; padding: 10px; margin-bottom: 15px;" required>
        <br>

        <label for="kategori">Kategori:</label>
        <input type="text" id="kategori" name="kategori" value="{{ old('kategori') }}" style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <br>

        <label for="tanggal_rilis">Tanggal Rilis:</label>
        <input type="date" id="tanggal_rilis" name="tanggal_rilis" value="{{ old('tanggal_rilis') }}" style="width: 75%; padding: 10px; margin-bottom: 15px;" required>
        <br>

        <label for="abstract" style="vertical-align: top;">Deskripsi:</label>
        <textarea id="abstract" name="abstract" rows="5" style="width: 75%; padding: 10px; margin-bottom: 15px; font-family: inherit;">{{ old('abstract') }}</textarea>
        <br>

        <label for="sampul">Sampul:</label>
        <input type="file" id="sampul" name="sampul" style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <br><br>

        <input type="submit" value="Simpan Publikasi" class="btn-tampilkan">
        <a href="{{ route('publikasi.index') }}" style="margin-left: 15px; color: #d9534f; text-decoration: none;">Batal</a>
    </form>
</main>
@endsection