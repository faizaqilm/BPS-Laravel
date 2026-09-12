<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    public function index(Request $request){
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

    public function create(){
        return view('publikasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'sampul' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('sampul')) {
            $file = $request->file('sampul');
            $filename = uniqid('publikasi_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/publikasi'), $filename);
            $data['sampul'] = 'images/publikasi/' . $filename;
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
            'judul' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'sampul' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('sampul')) {
            if ($publikasi->sampul) {
                Storage::disk('public')->delete($publikasi->sampul);
            }
            $file = $request->file('sampul');
            $filename = uniqid('publikasi_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/publikasi'), $filename);
            $data['sampul'] = 'images/publikasi/' . $filename;
        }

        $publikasi->update($data);

        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil diperbarui');
    }

    public function destroy(Publikasi $publikasi)
    {
        if ($publikasi->sampul) {
            Storage::disk('public')->delete($publikasi->sampul);
        }
        $publikasi->delete();

        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil dihapus');
    }
}