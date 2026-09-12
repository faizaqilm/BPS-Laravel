<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // Menampilkan halaman utama galeri
    public function index()
    {
        $galeriList = Galeri::orderBy('id', 'desc')->get();
        return view('galeri.index', compact('galeriList'));
    }

    // Menampilkan form tambah foto
    public function create()
    {
        return view('galeri.create');
    }

    // Proses simpan data ke database & folder
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'foto'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Simpan file ke folder storage/app/public/galeri
        $path = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'judul' => $request->judul,
            'foto'  => $path
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto Galeri berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit(Galeri $galeri)
    {
        return view('galeri.edit', compact('galeri'));
    }

    // Proses update data & ganti foto jika ada
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = ['judul' => $request->judul];

        // Jika user upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus file lama jika ada
            if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
                Storage::disk('public')->delete($galeri->foto);
            }
            // Simpan file baru
            $data['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->update($data);
        return redirect()->route('galeri.index')->with('success', 'Data Galeri berhasil diperbarui!');
    }

    // Proses hapus data
    public function destroy(Galeri $galeri)
    {
        // Hapus file fisik dari storage
        if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
            Storage::disk('public')->delete($galeri->foto);
        }
        
        $galeri->delete();
        return redirect()->route('galeri.index')->with('success', 'Foto Galeri berhasil dihapus permanen!');
    }
}