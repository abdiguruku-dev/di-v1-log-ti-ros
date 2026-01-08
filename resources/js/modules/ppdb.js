/* =========================================
   PPDB WIZARD LOGIC
   ========================================= */

export function initPPDBWizard() {
    const wizardContainer = document.querySelector('.wizard-container');
    if (!wizardContainer) return;

    const steps = document.querySelectorAll('.wizard-step'); // Konten per step
    const indicators = document.querySelectorAll('.step-item'); // Bulatan angka di atas
    const btnNext = document.querySelector('.btn-next');
    const btnPrev = document.querySelector('.btn-prev');
    let currentStep = 0;

    function showStep(index) {
        // Sembunyikan semua step
        steps.forEach((step, i) => {
            step.style.display = (i === index) ? 'block' : 'none';
        });

        // Update indikator bulat
        indicators.forEach((ind, i) => {
            if (i === index) ind.classList.add('active');
            else if (i < index) ind.classList.add('completed');
            else ind.classList.remove('active', 'completed');
        });

        // Atur tombol
        if (btnPrev) btnPrev.style.display = (index === 0) ? 'none' : 'inline-block';
        if (btnNext) btnNext.textContent = (index === steps.length - 1) ? 'Kirim Data' : 'Lanjut';
    }

    if (btnNext) {
        btnNext.addEventListener('click', () => {
            // TODO: Tambah validasi di sini sebelum lanjut
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            } else {
                // Submit Form
                document.getElementById('form-ppdb').submit();
            }
        });
    }

    if (btnPrev) {
        btnPrev.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    }

    // Init pertama
    showStep(0);
}