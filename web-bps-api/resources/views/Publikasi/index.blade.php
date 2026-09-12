@extends('layouts.app')
@section('title', 'Daftar Publikasi')

@section('content')
<div class="publikasi-wrapper">
    <aside class="filter-sidebar-modern">
        <form method="GET" action="{{ route('publikasi.index') }}">
            <label for="keyword">Kata Kunci</label>
            <input type="text" id="keyword" name="keyword" value="{{ request('keyword') }}" placeholder="Masukkan kata kunci...">

            <label for="tahun">Tahun</label>
            <select id="tahun" name="tahun">
                <option value="">Pilih Tahun</option>
                @for ($y = now()->year; $y >= 2010; $y--)
                    <option value="{{ $y }}" {{ (string) request('tahun') === (string) $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <label for="urutkan">Urutkan</label>
            <select id="urutkan" name="urutkan">
                <option value="terbaru" {{ request('urutkan', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('urutkan') === 'terlama' ? 'selected' : '' }}>Terlama</option>
            </select>

            <button type="submit" class="btn-modern-submit">Tampilkan</button>

            @if (request('keyword') || request('tahun') || request('urutkan'))
                <a href="{{ route('publikasi.index') }}" class="reset-filter">Reset Filter</a>
            @endif
        </form>
    </aside>

    <section class="publikasi-hasil">
        <div class="publikasi-header">
            @auth
                <a href="{{ route('publikasi.create') }}" class="btn-sync">+ Tambah Publikasi</a>
            @endauth
            <h1>Daftar Publikasi BPS Kaltara</h1>
            <p class="info-jumlah">Menampilkan {{ $publikasi->total() }} publikasi</p>
        </div>

        @if (session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif

        <div class="publikasi-list">
            @forelse ($publikasi as $item)
                <article class="publikasi-card">
                    <img src="{{ $item->sampul ? asset($item->sampul) : asset('images/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg') }}" alt="{{ $item->judul }}">
                    <div class="publikasi-info">
                        <div class="meta-text">{{ \Carbon\Carbon::parse($item->tanggal_rilis)->translatedFormat('j F Y') }}</div>
                        <div class="publikasi-judul-link">{{ $item->judul }}</div>

                        @auth
                            <div class="publikasi-aksi-admin">
                                <a href="{{ route('publikasi.edit', $item) }}">Ubah</a>
                                <form action="{{ route('publikasi.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none;border:none;color:#d9534f;cursor:pointer;">Hapus</button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </article>
            @empty
                <p class="empty-state">Tidak ada publikasi yang cocok.</p>
            @endforelse
        </div>

        <div style="margin-top:30px;">
            {{ $publikasi->links() }}
        </div>
    </section>
</div>
@endsection