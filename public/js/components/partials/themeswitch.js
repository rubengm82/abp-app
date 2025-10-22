////////////////////////////
//// DARK & LIGHT THEME ////
////////////////////////////

// Script for theme persistence in localStorage
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('theme-toggle');
    const html = document.documentElement;

    // Inicializa desde localStorage
    const storedTheme = localStorage.getItem('theme') || 'light'; // default light
    html.setAttribute('data-theme', storedTheme);
    toggle.checked = storedTheme === 'dark';

    // Cambia tema al toggle
    toggle.addEventListener('change', function () {
        const theme = toggle.checked ? 'dark' : 'light';
        html.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
    });
});