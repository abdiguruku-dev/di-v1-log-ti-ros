<aside id="sidebar" class="sidebar-glass -translate-x-full sm:translate-x-0">
    
    <div class="sidebar-header">
        <div class="logo-icon">
            <i class="fa-solid fa-school"></i>
        </div>
        <div class="logo-text-container">
            <h1 class="app-title">SEKOLAH JUARA</h1>
            <p class="app-subtitle">Sistem Informasi Akademik</p>
        </div>
    </div>

    <div class="sidebar-scroll-area custom-scrollbar">
        <ul class="space-y-1">
            
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-section-label px-4 py-2 mt-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                Master Data
            </li>
            
            <li>
                <a href="{{ route('admin.murid.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.murid.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Data Murid</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-chalkboard-user w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Data Guru & Staf</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-user-tie w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Data Alumni</span>
                </a>
            </li>

            <li class="sidebar-section-label px-4 py-2 mt-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                Akademik
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-calendar-days w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Tahun Ajaran</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-book-open w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Kurikulum</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-school w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Data Kelas</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-book w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Mata Pelajaran</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-calendar-week w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Jadwal Pelajaran</span>
                </a>
            </li>

            <li class="px-4 py-2 mt-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                Kesiswaan
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-id-card w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">PPDB Online</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-right-left w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Mutasi Siswa</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-user-shield w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Konseling / BK</span>
                </a>
            </li>

            <li class="sidebar-section-label px-4 py-2 mt-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                Keuangan
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-file-invoice-dollar w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Tagihan SPP</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.keuangan.bayar') }}" 
                   class="nav-link {{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cash-register w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Transaksi Kasir</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-chart-line w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Laporan Keuangan</span>
                </a>
            </li>

            <li class="sidebar-section-label px-4 py-2 mt-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                Sarpras
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-boxes-stacked w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Inventaris Aset</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-book-bookmark w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Perpustakaan</span>
                </a>
            </li>

            <li class="sidebar-section-label px-4 py-2 mt-4 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                Sistem
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-building w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Profil Sekolah</span>
                </a>
            </li>
            
            @role('super-admin')
            <li>
                <a href="{{ route('admin.users.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-gear w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Manajemen User</span>
                </a>
            </li>
            @endrole

            <li>
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-gear w-6 text-center"></i>
                    <span class="nav-text ml-3 font-medium">Pengaturan App</span>
                </a>
            </li>

        </ul>
    </div>
</aside>