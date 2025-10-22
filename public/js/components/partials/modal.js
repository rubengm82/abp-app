document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.accept-btn-container').forEach(container => {
    const btn = container.querySelector('button, a');

    if (btn) {
      btn.addEventListener('click', e => {
        const tag = btn.tagName.toLowerCase();

        // For -> <button>
        if (tag === 'button') {
          if (btn.disabled) {
            e.preventDefault();
          } else {
            btn.disabled = true;
            btn.textContent = 'Processant...';

            const form = btn.closest('form');
            if (form) {
              e.preventDefault();
              form.submit();
            }
          }
        }

        // For -> <a>
        else if (tag === 'a') {
          if (btn.classList.contains('disabled')) {
            e.preventDefault();
          } else {
            e.preventDefault();
            btn.classList.add('disabled', 'btn-neutral');
            btn.classList.remove('btn-error', 'btn-primary', 'btn-success');
            btn.style.pointerEvents = 'none';
            btn.textContent = 'Processant...';

            window.location.href = btn.href;
          }
        }
      });
    }
  });
});
