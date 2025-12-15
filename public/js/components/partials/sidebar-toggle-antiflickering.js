const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
if (isCollapsed) {
    document.documentElement.setAttribute('data-sidebar-collapsed', 'true');
}

