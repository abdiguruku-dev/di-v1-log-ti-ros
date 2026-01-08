@extends('layouts.app') {{-- Pastikan extend ke layout utama kita --}}

@section('title', 'Dashboard Admin')

@section('content')

    <div class="relative w-full rounded-[20px] p-8 mb-8 overflow-hidden shadow-xl shadow-emerald-400/20" 
         style="background: linear-gradient(135deg, #1a5f7a, #23d5ab);">
        
        <div class="absolute -top-5 -right-5 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 right-20 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>

        <div class="relative z-10 text-white">
            <h2 class="text-3xl font-extrabold mb-2">
                Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}! 👋
            </h2>
            <p class="text-white/90 text-sm md:text-base font-medium max-w-2xl">
                Ini adalah ringkasan aktivitas sekolah hari ini. Semua sistem berjalan optimal dan siap digunakan.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    
        <div class="card-glass p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 my-1">1,250</h3>
                    <span class="text-xs font-semibold text-emerald-500">
                        <i class="fa-solid fa-arrow-up mr-1"></i> +45 Siswa Baru
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#e0f2fe] flex items-center justify-center text-[#0ea5e9] text-xl">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
        </div>

        <div class="card-glass p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Guru & Staf</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 my-1">84</h3>
                    <span class="text-xs font-semibold text-slate-500">
                        98% Hadir Hari Ini
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#fdf2f8] flex items-center justify-center text-[#db2777] text-xl">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
        </div>

        <div class="card-glass p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kas Masuk (Bulan Ini)</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 my-1">Rp 450M</h3>
                    <span class="text-xs font-semibold text-emerald-600">
                        <i class="fa-solid fa-check mr-1"></i> 80% Lunas
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#ecfccb] flex items-center justify-center text-[#65a30d] text-xl">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
            </div>
        </div>

        <div class="card-glass p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Kelas</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 my-1">32</h3>
                    <span class="text-xs font-semibold text-slate-500">
                        Rombongan Belajar
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#fff7ed] flex items-center justify-center text-[#ea580c] text-xl">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/60 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg font-bold text-slate-700">Statistik Kehadiran</h4>
                <select class="text-xs border border-gray-300 rounded-lg px-3 py-1.5 bg-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                </select>
            </div>
            
            <div class="h-64 w-full bg-slate-50 rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400">
                <i class="fa-solid fa-chart-area text-4xl mb-2 opacity-50"></i>
                <span class="text-sm font-medium">Area Grafik Kehadiran</span>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/60 shadow-sm">
            <h4 class="text-lg font-bold text-slate-700 mb-6">Pengumuman Terbaru</h4>
            
            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                        <i class="fa-solid fa-bell text-lg"></i>
                    </div>
                    <div>
                        <h5 class="font-bold text-slate-800 text-sm">Rapat Wali Murid</h5>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Sabtu, 20 Agustus 2025 di Aula Utama Lt. 2.
                        </p>
                    </div>
                </div>

                <div class="border-b border-gray-100"></div>

                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-500 flex-shrink-0">
                        <i class="fa-solid fa-calendar-day text-lg"></i>
                    </div>
                    <div>
                        <h5 class="font-bold text-slate-800 text-sm">Ujian Tengah Semester</h5>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Dimulai tanggal 1 September 2025. Harap siapkan soal.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection