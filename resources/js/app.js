import './bootstrap';

// Import Komponen Modular
import { initSidebar } from './components/sidebar';
import { initNavbar } from './components/navbar';
import { initAlerts } from './components/alerts';
import { initModals } from './components/modal';

// Jalankan saat DOM (HTML) sudah siap
document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Inisialisasi Sidebar
    initSidebar();

    // 2. Inisialisasi Navbar
    initNavbar();

    // 3. Inisialisasi Alerts
    initAlerts();

    // 4. Inisialisasi Modals
    initModals();

    console.log('✨ Aurora System: All JavaScipt Modules Loaded!');
});