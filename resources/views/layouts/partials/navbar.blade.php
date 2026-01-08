<nav class="navbar-glass">

    <div class="flex items-center gap-4">
        <button id="sidebarToggle" class="navbar-toggle">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
        
        <div class="flex flex-col">
            <h1 class="text-lg font-bold text-slate-800 leading-tight">
                @yield('title', 'Dashboard') 
            </h1>
            @hasSection('subtitle')
                <p class="text-[11px] text-slate-500 font-medium leading-none mt-0.5">
                    @yield('subtitle')
                </p>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-4">

        <div class="relative">
            
            <button id="profileBtn" class="profile-pill focus:outline-none group">
                
                <div class="text-right hidden md:block leading-tight mr-1">
    
                    <p class="text-sm font-bold text-slate-700">
                        Hi, {{ Auth::user()->name }}
                    </p>
                    
                    <p class="text-[11px] text-slate-500 font-medium capitalize">
                        {{ Auth::user()->role }}
                    </p>

                </div>

                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    A
                </div>
            
            </button>

            <div id="profileMenu" class="profile-dropdown">
                
                <div class="dropdown-header-aurora">
                    
                    <div class="dropdown-avatar-lg mb-2">
                        A
                    </div>
                    
                    <div class="text-center text-white">
                        <p class="text-base font-bold leading-tight">Administrator</p>
                        
                        <p class="text-[10px] text-white/90 font-medium mt-1 bg-white/20 px-2 py-0.5 rounded-full inline-block backdrop-blur-sm">
                            Admin Sekolah
                        </p>
                    </div>

                </div>
                
                <div class="dropdown-body">
                    
                    <a href="#" class="dropdown-item-aesthetic">
                        <i class="fa-regular fa-user"></i>
                        <span>Profil Saya</span>
                    </a>
                    
                    <a href="#" class="dropdown-item-aesthetic">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Pengaturan Akun</span>
                    </a>

                    <div class="h-px bg-slate-100 my-2 mx-2"></div>
                    
                    <a href="#" class="dropdown-item-aesthetic">
                        <i class="fa-regular fa-circle-question"></i>
                        <span>Pusat Bantuan</span>
                    </a>

                </div>

            </div>
        </div>

        <div class="h-8 w-[1px] bg-slate-200 hidden md:block"></div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout" title="Keluar Aplikasi">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
        </form>

    </div>
</nav>