@if ($paginator->hasPages())
    <div style="display: flex; justify-content: center; gap: 8px; margin-top: 30px; flex-wrap: wrap;">
        
        {{-- Loop Angka Paginasi (Tanpa Panah Previous/Next seperti PHP Native asli) --}}
        @foreach ($elements as $element)
            
            {{-- Jika berupa array link halaman --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 8px 14px; border-radius: 4px; border: 1px solid #008be5; background-color: #008be5; color: white; font-weight: bold;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding: 8px 14px; border-radius: 4px; text-decoration: none; border: 1px solid #008be5; color: #008be5; background-color: white; transition: 0.2s;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif

        @endforeach
        
    </div>
@endif