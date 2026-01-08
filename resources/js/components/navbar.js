export function initNavbar() {
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    // Pastikan elemennya ada dulu biar gak error
    if (profileBtn && profileMenu) {
        
        // 1. KLIK TOMBOL: Toggle Menu (Buka/Tutup)
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Mencegah event nembus ke body
            profileMenu.classList.toggle('active');
        });

        // 2. KLIK DI LUAR: Tutup Menu
        document.addEventListener('click', (e) => {
            // Jika yang diklik BUKAN tombol profile DAN BUKAN menu dropdown
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.remove('active');
            }
        });
    }
}