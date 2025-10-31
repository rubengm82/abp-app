document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const submit = form.querySelector('[type="submit"]');
            if (submit) {
                submit.disabled = true;
                submit.value = 'Processant...'; // si es input
                submit.innerText = 'Processant...'; // si es button
            }
        });
    });
});