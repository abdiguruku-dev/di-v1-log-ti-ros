<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data kelas untuk Filter Dropdown
        $dataKelas = Kelas::all();

        // 2. Query Utama Data Murid (dengan Relasi Kelas)
        $query = Murid::with('kelas');

        // 3. Logika Pencarian (Search Bar)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nis', 'LIKE', "%{$search}%")
                  ->orWhere('nisn', 'LIKE', "%{$search}%");
            });
        }

        // 4. Logika Filter Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        // 5. Eksekusi & Pagination (Tampilkan 10 per halaman)
        // Kita urutkan berdasarkan nama abjad A-Z
        $murids = $query->orderBy('nama_lengkap', 'asc')->paginate(12)->withQueryString();
        $perPage = $request->input('per_page', 12); // Default 12
        $murids = $query->orderBy('nama_lengkap', 'asc')->paginate($perPage)->withQueryString();

        return view('pages.admin.murid.index', compact('murids', 'dataKelas'));
    }
    
    
    // Nanti kita tambah function create, store, edit, dll disini
}