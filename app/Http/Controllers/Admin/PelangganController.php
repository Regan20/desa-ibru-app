<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::with('desa')->latest('id')->get();
        $desas = Desa::all();

        $stat = [
            'total'    => Pelanggan::count(),
            'aktif'    => Pelanggan::where('status', 'Aktif')->count(),
            'nonaktif' => Pelanggan::where('status', 'Nonaktif')->count(),
            'tunggakan'=> Pelanggan::where('status', 'Tunggakan')->count(),
        ];

        return view('admin.pelanggan.index', compact('pelanggans', 'desas', 'stat'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['pemakaian'] = 0;
        Pelanggan::create($data);

        return back()->with('success', 'Pelanggan baru ditambahkan.');
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $this->validateData($request, $pelanggan->id);
        $pelanggan->update($data);

        return back()->with('success', 'Data pelanggan diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return back()->with('success', 'Pelanggan dihapus.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'kode'     => ['required', 'string', 'max:50', 'unique:pelanggans,kode' . ($ignoreId ? ",$ignoreId" : '')],
            'nama'     => ['required', 'string', 'max:255'],
            'desa_id'  => ['required', 'exists:desas,id'],
            'wilayah'  => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'hp'       => ['nullable', 'string', 'max:20'],
            'status'   => ['required', 'string'],
        ]);
    }
}
