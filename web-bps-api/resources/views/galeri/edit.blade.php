@extends('layouts.app')
@section('title', 'Edit Foto Galeri')

@section('content')
<main class="kotak" style="margin-top: 120px;">
    <h1>Edit Data Galeri</h1>

    @if ($errors->any())
        <div style="color:red; margin-bottom:15px; border: 1px solid red; padding:10px; background-color:#fdd;">
            <ul style="margin:0;">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="judul">Keterangan:</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}" required style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <br>

        <label>Foto Saat Ini:</label>
        <img src="{{ asset('storage/' . $galeri->foto) }}" width="120" style="display:inline-block; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;">
        <br>

        <label for="foto">Ganti Foto:</label>
        <input type="file" id="foto" name="foto" style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <span style="font-size: 12px; color: #666; margin-left: 135px;">(Kosongkan jika tidak ingin mengganti foto)</span>
        <br><br>

        <input type="submit" value="Simpan Perubahan" class="btn-tampilkan">
        <a href="{{ route('galeri.index') }}" style="margin-left: 15px; color: #d9534f; text-decoration: none;">Batal</a>
    </form>
</main>
@endsection