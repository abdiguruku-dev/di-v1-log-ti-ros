export function initAlerts() {
    // 1. Tombol Close Manual
    const closeButtons = document.querySelectorAll('.alert-close'); // Pastikan di HTML ada class ini
    
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const alertBox = this.closest('.alert');
            dismissAlert(alertBox);
        });
    });

    // 2. Auto Dismiss (Hanya untuk Alert Sukses)
    const successAlerts = document.querySelectorAll('.alert-success');
    if (successAlerts.length > 0) {
        setTimeout(() => {
            successAlerts.forEach(alert => dismissAlert(alert));
        }, 5000); // Hilang dalam 5 detik
    }
}

// Helper Function: Efek menghilang halus
function dismissAlert(element) {
    if(!element) return;
    element.style.transition = "opacity 0.5s ease, transform 0.5s ease";
    element.style.opacity = '0';
    element.style.transform = 'translateY(-10px)';
    
    setTimeout(() => {
        element.remove();
    }, 500);
}