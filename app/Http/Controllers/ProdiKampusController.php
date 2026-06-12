<?php

namespace App\Http\Controllers;

use App\Models\Kampus;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class ProdiKampusController extends Controller {
    public function index(Request $request) {
        $allKampus = Kampus::orderBy('nama_kampus', 'ASC')->get();
        
        $selectedId = $request->query('id_kampus', $allKampus->first()?->id_kampus ?? 0);
        $selectedKampus = Kampus::where('id_kampus', $selectedId)->first();
        
        $allJurusan = Jurusan::orderBy('nama_jurusan', 'ASC')->get()->groupBy(function($j) {
            return $j->kategori_relevan ? trim(explode(',', $j->kategori_relevan)[0]) : 'Umum';
        });

        // SESUAIKAN: Menggunakan $selectedKampus->jurusan() sesuai nama method di Model
        $terhubung = [];
        if ($selectedKampus && method_exists($selectedKampus, 'jurusan')) {
            $terhubung = $selectedKampus->jurusan()->pluck('jurusan.id_jurusan')->toArray();
        }

        return view('admin.manage_prodi', compact('allKampus', 'selectedKampus', 'allJurusan', 'terhubung', 'selectedId'));
    }

    public function update(Request $request) {
        $request->validate([
            'id_kampus' => 'required',
            'jurusan_ids' => 'nullable|array'
        ]);

        $kampus = Kampus::where('id_kampus', $request->id_kampus)->firstOrFail();
        
        // SESUAIKAN: Menggunakan ->jurusan()->sync(...)
        $kampus->jurusan()->sync($request->jurusan_ids ?? []);

        return redirect()->route('prodi.index', ['id_kampus' => $kampus->id_kampus])
                         ->with('success', 'Prodi berhasil diperbarui!');
    }
}