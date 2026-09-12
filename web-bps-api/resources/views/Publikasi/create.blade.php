@extends('layouts.app')
@section('title', 'Tambah Publikasi')

@section('content')
<main class="kotak">
    <h1>Form Penambahan Publikasi Baru</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('publikasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul') }}">
        <br><br>

        <label for="tanggal_rilis">Tanggal Rilis:</label>
        <input type="date" id="tanggal_rilis" name="tanggal_rilis" value="{{ old('tanggal_rilis') }}">
        <br><br>

        <label for="sampul">Sampul:</label>
        <input type="file" id="sampul" name="sampul">
        <br><br>

        <input type="submit" value="Tambah">
    </form>
</main>
@endsection