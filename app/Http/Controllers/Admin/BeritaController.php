<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest('id')->get();

        $stat = [
            'total'       => Berita::count(),
            'dipublikasi' => Berita::where('status', 'Dipublikasi')->count(),
            'draft'       => Berita::where('status', 'Draft')->count(),
        ];

        return view('admin.berita.index', compact('beritas', 'stat'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        unset($data['gambar']); // file ditangani terpisah di bawah

        $data['views']   = 0;
        $data['tanggal'] = now()->translatedFormat('l, d F Y');
        $data['badge']   = 'badge-blue';

        if ($path = $this->handleUpload($request)) {
            $data['gambar'] = $path;
        }

        Berita::create($data);

        return back()->with('success', 'Berita baru berhasil disimpan.');
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $this->validateData($request);
        unset($data['gambar']); // hanya ganti gambar bila ada unggahan baru

        if ($path = $this->handleUpload($request)) {
            $data['gambar'] = $path;
        }

        $berita->update($data);

        return back()->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();
        return back()->with('success', 'Berita dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'judul'    => ['required', 'string', 'max:255'],
            'sub'      => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'status'   => ['required', 'in:Draft,Dipublikasi'],
            'isi'      => ['nullable', 'string'],
            'gambar'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    /** Simpan gambar yang diunggah ke public/uploads/berita dan kembalikan path relatifnya. */
    private function handleUpload(Request $request): ?string
    {
        if (! $request->hasFile('gambar')) {
            return null;
        }

        $file = $request->file('gambar');
        $name = 'berita-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $dir  = public_path('uploads/berita');

        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $file->move($dir, $name);

        return 'uploads/berita/' . $name;
    }
}
