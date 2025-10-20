document.addEventListener('DOMContentLoaded', () => {

    // Open modal
    document.querySelectorAll('[data-open-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.openModal);
            if (modal) modal.showModal();
        });
    });

    // Close modal
    document.querySelectorAll('[data-close-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.closeModal);
            if (modal) modal.close();
        });
    });

    // Prevent double submit and change button text
    document.querySelectorAll('dialog form').forEach(form => {
    form.addEventListener('submit', e => {
            const btn = form.querySelector('[type="submit"]');

            if (btn) {
                const text = btn.dataset.loadingText || 'Processing...';

                if (!btn.disabled) {
                    btn.textContent = text;
                    setTimeout(() => btn.disabled = true, 1);
                } else {
                    e.preventDefault();
                }
            }
        });
    });


});
