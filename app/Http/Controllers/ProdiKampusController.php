<?php

namespace App\Http\Controllers;

use App\Models\Kampus;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class ProdiKampusController extends Controller {
    public function index(Request $request) {
        $allKampus = Kampus::orderBy('nama_kampus', 'ASC')->get();
        $selectedId = $request->query('id_kampus', $allKampus->first()?->id ?? 0);
        
        $selectedKampus = Kampus::find($selectedId);
        $allJurusan = Jurusan::orderBy('nama_jurusan', 'ASC')->get()->groupBy(fn($j) => explode(',', $j->kategori_relevan)[0]);
        $terhubung = $selectedKampus ? $selectedKampus->jurusans->pluck('id')->toArray() : [];

        return view('admin.manage_prodi', compact('allKampus', 'selectedKampus', 'allJurusan', 'terhubung', 'selectedId'));
    }

    public function update(Request $request) {
        $kampus = Kampus::findOrFail($request->id_kampus);
        $kampus->jurusans()->sync($request->jurusan_ids ?? []);

        return redirect()->route('prodi.index', ['id_kampus' => $kampus->id])
                         ->with('success', 'Prodi berhasil diperbarui!');
    }
}