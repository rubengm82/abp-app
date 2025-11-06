document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('tableToSearch-container');
    const searchInput = document.getElementById('search');

    if (container && searchInput) {
        const baseUrl = container.dataset.url;
        let searchTerm = '';
        let searchTimer;

        function loadData(url = baseUrl) {
            const fullUrl = url + (url.includes('?') ? '&' : '?') + 'search=' + encodeURIComponent(searchTerm);
            fetch(fullUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    container.innerHTML = html;
                })
                .catch(err => console.error('Error loading data:', err));
        }

        container.addEventListener('click', e => {
            if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
                e.preventDefault();
                loadData(e.target.href);
            }
        });

        searchInput.addEventListener('input', e => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                searchTerm = e.target.value;
                loadData(baseUrl + '?page=1');
            }, 400);
        });
    }
});
