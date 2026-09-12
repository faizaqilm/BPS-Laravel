@extends('layouts.app')
@section('title', 'Ubah Publikasi')

@section('content')
<main class="kotak">
    <h1>Formulir Ubah Data Publikasi</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('publikasi.update', $publikasi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $publikasi->judul) }}">
        <br><br>

        <label for="tanggal_rilis">Tanggal Rilis:</label>
        <input type="date" id="tanggal_rilis" name="tanggal_rilis" value="{{ old('tanggal_rilis', $publikasi->tanggal_rilis) }}">
        <br><br>

        @if ($publikasi->sampul)
            <label>Sampul Lama:</label>
            <img src="{{ asset($item->sampul) }}" width="70"><br><br>
        @endif

        <label for="sampul">Sampul Baru:</label>
        <input type="file" id="sampul" name="sampul">
        <br><br>

        <input type="submit" value="Ubah Data">
    </form>
</main>
@endsection