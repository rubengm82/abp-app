document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('tableToSearch-container');
    const searchInput = document.getElementById('search');
    const baseUrl = container.dataset.url; // Get the base URL from the container's data-url attribute
    let searchTerm = '';
    let searchTimer;

    // Load data via AJAX
    function loadData(url = baseUrl) {
        const fullUrl = url + (url.includes('?') ? '&' : '?') + 'search=' + encodeURIComponent(searchTerm);
        fetch(fullUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;
        })
        .catch(err => console.error('Error loading data:', err));
    }

    // Intercept pagination link clicks
    container.addEventListener('click', e => {
        if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
            e.preventDefault();
            loadData(e.target.href);
        }
    });

    // Search with delay (debounce)
    searchInput.addEventListener('input', e => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            searchTerm = e.target.value;
            loadData(baseUrl + '?page=1');
        }, 400);
    });
});