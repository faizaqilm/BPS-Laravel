@extends('layouts.app')
@section('title', 'Tambah Publikasi')

@push('styles')
<style>
    /* ─── STYLING FORM TAMBAH PUBLIKASI (PROFESIONAL & CLEAN) ─── */
    .form-page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
        min-height: calc(100vh - 180px);
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(2, 54, 91, 0.08);
        width: 100%;
        max-width: 680px;
        padding: 40px 40px;
        box-sizing: border-box;
    }

    .form-header {
        margin-bottom: 28px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 16px;
    }

    .form-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--biru-tua, #02365b);
        margin: 0;
    }

    .form-group-modern {
        margin-bottom: 20px;
    }

    .form-group-modern label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        width: auto !important;
    }

    .form-control-modern {
        width: 100% !important;
        padding: 12px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        color: #1e293b;
        background-color: #f8fafc;
        box-sizing: border-box;
        transition: border-color 0.15s, background-color 0.15s;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: var(--biru, #034f84);
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(3, 79, 132, 0.1);
    }

    textarea.form-control-modern {
        resize: vertical;
        min-height: 120px;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-submit-modern {
        background-color: var(--biru, #034f84);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 14.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background-color 0.15s;
    }

    .btn-submit-modern:hover {
        background-color: var(--biru-tua, #02365b);
    }

    .btn-cancel-modern {
        color: #64748b;
        background-color: transparent;
        border: 1px solid #cbd5e1;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 14.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s;
    }

    .btn-cancel-modern:hover {
        background-color: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }

    .alert-error-modern {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 12px 14px;
        border-radius: 6px;
        font-size: 13.5px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="form-page-wrapper">
    <div class="form-card">
        <div class="form-header">
            <h1>Form Penambahan Publikasi Baru</h1>
        </div>

        @if ($errors->any())
            <div class="alert-error-modern">
                <ul style="margin:0; padding-left: 18px;">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('publikasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group-modern">
                <label for="judul">Judul Publikasi</label>
                <input type="text" id="judul" name="judul" class="form-control-modern" value="{{ old('judul') }}" placeholder="Masukkan judul publikasi..." required>
            </div>

            <div class="form-group-modern">
                <label for="kategori">Kategori</label>
                <input type="text" id="kategori" name="kategori" class="form-control-modern" value="{{ old('kategori') }}" placeholder="Contoh: Ekonomi, Sosial, Umum...">
            </div>

            <div class="form-group-modern">
                <label for="tanggal_rilis">Tanggal Rilis</label>
                <input type="date" id="tanggal_rilis" name="tanggal_rilis" class="form-control-modern" value="{{ old('tanggal_rilis') }}" required>
            </div>

            <div class="form-group-modern">
                <label for="abstract">Deskripsi / Abstrak</label>
                <textarea id="abstract" name="abstract" class="form-control-modern" placeholder="Tuliskan ringkasan isi publikasi...">{{ old('abstract') }}</textarea>
            </div>

            <div class="form-group-modern">
                <label for="sampul">File Sampul (Cover)</label>
                <input type="file" id="sampul" name="sampul" class="form-control-modern" style="padding: 10px; background: white;">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit-modern">Simpan Publikasi</button>
                <a href="{{ route('publikasi.index') }}" class="btn-cancel-modern">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection