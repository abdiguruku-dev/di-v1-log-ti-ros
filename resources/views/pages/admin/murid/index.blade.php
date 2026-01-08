@extends('layouts.app')

@section('title', 'Data Murid')

@section('content')
<div class="w-full px-6 py-6">

    <div class="bg-white/60 backdrop-blur-lg rounded-2xl p-1 shadow-sm border border-slate-200/60 mb-6">
        <form action="{{ route('admin.murid.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-center justify-between">
            
            <div class="flex flex-col md:flex-row gap- w-full md:w-auto flex-1">
                <div class="relative w-full md:w-64">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama / NISN..." 
                           class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 bg-white/50">
                </div>

                <div class="relative w-full md:w-48">
                    <i class="fa-solid fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <select name="kelas_id" onchange="this.form.submit()" 
                            class="w-full pl-10 pr-8 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 bg-white/50 appearance-none cursor-pointer">
                        <option value="">Semua Kelas</option>
                        @foreach($dataKelas as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded-xl shadow-lg hover:bg-indigo-700 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span class="hidden md:inline">Murid Baru</span>
                </a>
            </div>

            <div class="flex bg-slate-100 p-1 rounded-lg border border-slate-200">
                <button type="button" id="btn-grid" onclick="switchView('grid')" 
                        class="p-2 rounded-md text-slate-500 hover:text-indigo-600 transition-all active-view">
                    <i class="fa-solid fa-grid-2"></i>
                </button>
                <button type="button" id="btn-list" onclick="switchView('list')" 
                        class="p-2 rounded-md text-slate-500 hover:text-indigo-600 transition-all">
                    <i class="fa-solid fa-list"></i>
                </button>
            </div>

        </form>
    </div>

    <div id="view-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 animate-fade-in-up">
        @forelse($murids as $murid)
        <div class="group relative bg-white/70 backdrop-blur-md rounded-2xl p-5 border border-slate-200/60 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            
            <div class="absolute top-4 right-4">
                <span class="px-2 py-1 text-[10px] font-bold rounded-full {{ $murid->status == 'aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    {{ strtoupper($murid->status ?? 'AKTIF') }}
                </span>
            </div>

            <div class="flex flex-col items-center text-center mt-2">
                <div class="w-20 h-20 rounded-full p-1 bg-gradient-to-tr from-indigo-500 to-pink-500 mb-3 group-hover:scale-105 transition-transform">
                    <img src="{{ $murid->foto ? asset('storage/'.$murid->foto) : 'https://ui-avatars.com/api/?name='.urlencode($murid->nama_lengkap).'&background=random' }}" 
                         alt="{{ $murid->nama_lengkap }}" 
                         class="w-full h-full rounded-full object-cover border-2 border-white">
                </div>
                
                <h3 class="font-bold text-slate-800 text-lg line-clamp-1">{{ $murid->nama_lengkap }}</h3>
                <p class="text-xs text-slate-500 font-medium mb-1">{{ $murid->nisn ?? '-' }}</p>
                
                <div class="mt-2 px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold border border-indigo-100">
                    {{ $murid->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center">
                <div class="text-xs text-slate-400">
                    <i class="fa-solid fa-venus-mars mr-1"></i> {{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </div>
                <a href="#" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-indigo-600 hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @empty
            <div class="col-span-full text-center py-20">
                <div class="inline-block p-4 rounded-full bg-slate-100 mb-4 text-slate-400">
                    <i class="fa-solid fa-user-slash text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-600">Tidak ada data murid</h3>
                <p class="text-slate-400 text-sm">Coba ubah filter pencarian Anda.</p>
            </div>
        @endforelse
    </div>

    <div id="view-list" class="hidden animate-fade-in-up">
        <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">NISN / NIS</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4">Gender</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($murids as $murid)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $murid->foto ? asset('storage/'.$murid->foto) : 'https://ui-avatars.com/api/?name='.urlencode($murid->nama_lengkap).'&background=random' }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $murid->nama_lengkap }}</div>
                                        <div class="text-xs text-slate-400">{{ $murid->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3">
                                <div class="font-medium">{{ $murid->nisn }}</div>
                                <div class="text-xs text-slate-400">{{ $murid->nis ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded text-xs font-bold border border-indigo-100">
                                    {{ $murid->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                {{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-1 text-[10px] font-bold rounded-full {{ $murid->status == 'aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    {{ strtoupper($murid->status ?? 'AKTIF') }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <a href="#" class="text-slate-400 hover:text-indigo-600 px-2 transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $murids->links() }}
    </div>

</div>

<script>
    // Cek LocalStorage saat load
    document.addEventListener("DOMContentLoaded", function() {
        const savedView = localStorage.getItem('muridViewMode') || 'grid';
        switchView(savedView);
    });

    function switchView(mode) {
        const gridView = document.getElementById('view-grid');
        const listView = document.getElementById('view-list');
        const btnGrid = document.getElementById('btn-grid');
        const btnList = document.getElementById('btn-list');

        if (mode === 'grid') {
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');
            
            // Update Tombol Style
            btnGrid.classList.add('bg-white', 'shadow-sm', 'text-indigo-600');
            btnList.classList.remove('bg-white', 'shadow-sm', 'text-indigo-600');
        } else {
            gridView.classList.add('hidden');
            listView.classList.remove('hidden');
            
            // Update Tombol Style
            btnList.classList.add('bg-white', 'shadow-sm', 'text-indigo-600');
            btnGrid.classList.remove('bg-white', 'shadow-sm', 'text-indigo-600');
        }
        
        // Simpan preferensi user
        localStorage.setItem('muridViewMode', mode);
    }
</script>
@endsection