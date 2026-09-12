@extends('layouts.app')
@section('title', 'GALERI BPS KALTARA')

@section('content')
<main class="galeri" style="margin-top: 100px;">
    <h1>Galeri Kegiatan BPS Kalimantan Utara</h1>

    @if(session('success'))
        <div style="color: green; margin-bottom:15px; font-weight:bold;">{{ session('success') }}</div>
    @endif

    @auth
        <div style="margin-bottom: 20px; text-align: left;">
            <a href="{{ route('galeri.create') }}" class="btn-tampilkan" style="text-decoration: none; padding: 10px 20px; font-weight: bold;">+ Tambah Foto</a>
        </div>
    @endauth

    <div class="galeri-container">
        <div class="preview">
            @if($galeriList->count() > 0)
                <img id="imgPreview" src="{{ asset('storage/' . $galeriList->first()->foto) }}" alt="{{ $galeriList->first()->judul }}">
            @else
                <div style="padding: 100px; color: #777; background-color: #eee; border-radius: 4px;">Belum ada foto galeri yang diunggah.</div>
            @endif
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 15px;">
            @foreach($galeriList as $row)
                <div style="text-align: center; border: 1px solid #ddd; padding: 10px; border-radius: 4px; background-color: white;">
                    <img src="{{ asset('storage/' . $row->foto) }}" 
                         alt="{{ $row->judul }}" 
                         title="{{ $row->judul }}"
                         onclick="gantiPreview(this)" 
                         style="width: 100%; height: 120px; object-fit: cover; cursor: pointer; border-radius: 4px; transition: 0.2s;">
                    
                    <div style="font-size: 13px; margin-top: 10px; color: #333; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $row->judul }}
                    </div>

                    @auth
                        <div style="margin-top: 12px; font-size: 12px; display: flex; justify-content: center; gap: 8px;">
                            <a href="{{ route('galeri.edit', $row->id) }}" style="color: #034f84; text-decoration: none; border: 1px solid #034f84; padding: 4px 10px; border-radius: 4px;">Edit</a>
                            
                            <!-- Form Delete Aman (Anti CSRF) -->
                            <form action="{{ route('galeri.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #d9534f; background: none; border: 1px solid #d9534f; padding: 4px 10px; border-radius: 4px; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    @endauth
                </div>
            @endforeach
        </div>
    </div>
</main>

@push('scripts')
<script>
    function gantiPreview(el) {
        document.getElementById('imgPreview').src = el.src;
        document.getElementById('imgPreview').alt = el.alt;
    }
</script>
@endpush
@endsection