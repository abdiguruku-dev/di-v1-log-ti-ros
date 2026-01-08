export function initModals() {
    const triggers = document.querySelectorAll('[data-modal-target]');
    const closeBtns = document.querySelectorAll('[data-modal-hide]');
    
    // Buka Modal
    triggers.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-modal-target');
            const modal = document.getElementById(targetId);
            if(modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex'); // Gunakan flex agar centering jalan
                document.body.style.overflow = 'hidden'; // Matikan scroll body
            }
        });
    });

    // Tutup Modal
    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-modal-hide');
            const modal = document.getElementById(targetId);
            closeModal(modal);
        });
    });

    // Fungsi Tutup
    function closeModal(modal) {
        if(modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }
}