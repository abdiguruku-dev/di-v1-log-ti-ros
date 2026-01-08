export function initSidebar() {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar-glass');
    const mainWrapper = document.querySelector('.main-wrapper');
    
    // --- [BARU] 1. AMBIL ELEMENT NAVBAR ---
    const navbar = document.querySelector('.navbar-glass'); 

    const navLinks = document.querySelectorAll('.nav-link');

    // LOGIC MENU AKTIF (Biarkan tetap sama)
    const currentUrl = window.location.href;
    navLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
        }
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                sidebar.classList.remove('show-mobile'); 
                const overlay = document.getElementById('sidebarOverlay');
                if(overlay) overlay.classList.add('hidden');
            }
        });
    });

    // LOGIC HAMBURGER TOGGLE
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            if (window.innerWidth >= 768) {
                // --- MODE DESKTOP ---
                sidebar.classList.toggle('is-collapsed');
                if (mainWrapper) mainWrapper.classList.toggle('is-collapsed');
                
                // --- [BARU] 2. PERINTAHKAN NAVBAR UNTUK GESER ---
                if (navbar) navbar.classList.toggle('is-collapsed');
                
            } else {
                // --- MODE MOBILE ---
                sidebar.classList.toggle('show-mobile');
                const overlay = document.getElementById('sidebarOverlay');
                if(overlay) overlay.classList.toggle('hidden');
            }
        });
    }

    // LOGIC KLIK DI LUAR (MOBILE)
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 768) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('show-mobile');
                const overlay = document.getElementById('sidebarOverlay');
                if(overlay) overlay.classList.add('hidden');
            }
        }
    });
}

