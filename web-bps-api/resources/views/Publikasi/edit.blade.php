@extends('layouts.app')
@section('title', 'Ubah Publikasi')

@section('content')
<main class="kotak" style="margin-top: 100px;">
    <h1>Formulir Ubah Data Publikasi</h1>

    @if ($errors->any())
        <div style="color:red; background-color:#fdd; padding:10px; border:1px solid red; margin-bottom:15px;">
            <ul style="margin:0;">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('publikasi.update', $publikasi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $publikasi->judul) }}" style="width: 75%; padding: 10px; margin-bottom: 15px;" required>
        <br>

        <label for="kategori">Kategori:</label>
        <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $publikasi->kategori) }}" style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <br>

        <label for="tanggal_rilis">Tanggal Rilis:</label>
        <input type="date" id="tanggal_rilis" name="tanggal_rilis" value="{{ old('tanggal_rilis', $publikasi->tanggal_rilis) }}" style="width: 75%; padding: 10px; margin-bottom: 15px;" required>
        <br>

        <label for="abstract" style="vertical-align: top;">Deskripsi:</label>
        <textarea id="abstract" name="abstract" rows="5" style="width: 75%; padding: 10px; margin-bottom: 15px; font-family: inherit;">{{ old('abstract', $publikasi->abstract) }}</textarea>
        <br>

        @if ($publikasi->sampul)
            <label>Sampul Lama:</label>
            <img src="{{ asset('storage/' . $publikasi->sampul) }}" width="100" style="display:inline-block; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;">
            <br>
        @endif

        <label for="sampul">Sampul Baru:</label>
        <input type="file" id="sampul" name="sampul" style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <span style="font-size: 12px; color: #666; margin-left: 135px; display:block;">(Kosongkan jika tidak ingin mengganti sampul)</span>
        <br><br>

        <input type="submit" value="Simpan Perubahan" class="btn-tampilkan">
        <a href="{{ route('publikasi.index') }}" style="margin-left: 15px; color: #d9534f; text-decoration: none;">Batal</a>
    </form>
</main>
@endsection