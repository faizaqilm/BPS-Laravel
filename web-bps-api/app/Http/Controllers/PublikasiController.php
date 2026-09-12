<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Publikasi::query();

        if ($request->filled('keyword')) {
            $query->where('judul', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_rilis', $request->tahun);
        }

        $query->orderBy('tanggal_rilis', $request->urutkan === 'terlama' ? 'asc' : 'desc');

        $publikasi = $query->paginate(6)->withQueryString();

        return view('publikasi.index', compact('publikasi'));
    }

    public function create()
    {
        return view('publikasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'         => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'sampul'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori'      => 'nullable|string|max:255',
            'abstract'      => 'nullable|string',
        ]);

        if ($request->hasFile('sampul')) {
            $data['sampul'] = $request->file('sampul')->store('publikasi', 'public');
        }

        Publikasi::create($data);

        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil ditambahkan');
    }

    public function edit(Publikasi $publikasi)
    {
        return view('publikasi.edit', compact('publikasi'));
    }

    public function update(Request $request, Publikasi $publikasi)
    {
        $data = $request->validate([
            'judul'         => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'sampul'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori'      => 'nullable|string|max:255',
            'abstract'      => 'nullable|string',
        ]);

        if ($request->hasFile('sampul')) {
            if ($publikasi->sampul && Storage::disk('public')->exists($publikasi->sampul)) {
                Storage::disk('public')->delete($publikasi->sampul);
            }
            $data['sampul'] = $request->file('sampul')->store('publikasi', 'public');
        }

        $publikasi->update($data);

        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil diperbarui');
    }

    public function destroy(Publikasi $publikasi)
    {
        if ($publikasi->sampul && Storage::disk('public')->exists($publikasi->sampul)) {
            Storage::disk('public')->delete($publikasi->sampul);
        }
        $publikasi->delete();

        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil dihapus');
    }

    public function syncApi()
    {
        $domain = '6500';
        $apiKey = '5fe7ead70192dafd9cf4f06b0d10308f';

        // Ambil nomor halaman dari session, default mulai dari halaman 1
        $page = session('bps_sync_page', 1);

        $apiUrl = "https://webapi.bps.go.id/v1/api/list/model/publication/lang/ind/domain/{$domain}/page/{$page}/key/{$apiKey}/";

        try {
            $response = Http::withoutVerifying()->get($apiUrl);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['status']) && $result['status'] === 'OK' && isset($result['data'][1])) {
                    
                    $maxPages = isset($result['data'][0]['pages']) ? (int)$result['data'][0]['pages'] : 1;
                    $dataApi = array_slice($result['data'][1], 0, 10);
                    $sukses = 0;

                    foreach ($dataApi as $item) {
                        $kategori = 'Umum';
                        if (!empty($item['subject_csa'])) {
                            $kategori = implode(', ', $item['subject_csa']);
                        } elseif (!empty($item['schn'])) {
                            $kategori = $item['schn'];
                        }

                        Publikasi::updateOrCreate(
                            ['pub_id' => $item['pub_id']],
                            [
                                'judul'         => $item['title'],
                                'tanggal_rilis' => $item['rl_date'],
                                'sampul'        => $item['cover'],
                                'abstract'      => strip_tags($item['abstract'] ?? 'Tidak ada deskripsi.'),
                                'kategori'      => $kategori,
                                'pdf_link'      => $item['pdf'] ?? null,
                            ]
                        );
                        $sukses++;
                    }

                    // Geser ke halaman berikutnya untuk sinkronisasi selanjutnya
                    $nextPage = $page + 1;
                    if ($nextPage > $maxPages) {
                        $nextPage = 1; // Putar balik ke halaman 1 jika sudah habis
                    }
                    session(['bps_sync_page' => $nextPage]);

                    return redirect()->route('publikasi.index')->with('success', "Sukses! $sukses publikasi dari halaman $page berhasil ditarik dari API BPS.");
                }
            }
            
            session(['bps_sync_page' => 1]);
            return redirect()->route('publikasi.index')->withErrors(['Gagal mengambil data dari API BPS.']);
        } catch (\Exception $e) {
            return redirect()->route('publikasi.index')->withErrors(['Terjadi kesalahan koneksi API: ' . $e->getMessage()]);
        }
    }

    // Fungsi ini dipanggil secara asinkron oleh JavaScript (AJAX)
    public function getHint(Request $request)
    {
        $keyword = $request->query('keyword');
        
        if (empty($keyword)) {
            return response()->json([]);
        }

        $hints = Publikasi::where('judul', 'like', '%' . $keyword . '%')
                    ->select('judul')
                    ->limit(5)
                    ->get();

        if ($hints->isEmpty()) {
            return response()->json([['judul' => 'no suggestion']]);
        }

        return response()->json($hints);
    }
}