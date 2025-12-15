document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById("sidebar-toggle");
    const html = document.documentElement;
    const sidebarCollapsedKey = "sidebar-collapsed";

    // Inicializa desde localStorage
    const isCollapsed = localStorage.getItem(sidebarCollapsedKey) === "true";
    html.setAttribute('data-sidebar-collapsed', isCollapsed ? 'true' : 'false');

    // Toggle del sidebar
    toggleButton.addEventListener("click", () => {
        const currentlyCollapsed = html.getAttribute('data-sidebar-collapsed') === 'true';
        const newState = !currentlyCollapsed;
        html.setAttribute('data-sidebar-collapsed', newState ? 'true' : 'false');
        localStorage.setItem(sidebarCollapsedKey, newState ? "true" : "false");
    });
});

