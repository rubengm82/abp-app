document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.accept-btn-container').forEach(container => {
        const btn = container.querySelector('button, a');

        if (btn) {
            btn.addEventListener('click', e => {
                if (btn.disabled) {
                    e.preventDefault();
                } else {
                    btn.disabled = true;
                    btn.textContent = 'Processant...';

                    const form = btn.closest('form');
                    if (form && btn.tagName.toLowerCase() === 'button') {
                        e.preventDefault();
                        form.submit();
                    }
                }
            });
        }
    });
});