/* SELECT ALL TOASTS AND AUTOMATICALLY CLOSE THEM AFTER 3 SECONDS */
document.addEventListener('DOMContentLoaded', function () {
    // Prevent showing toasts when navigating back/forward
    const navType = performance.getEntriesByType("navigation")[0].type;
    
    if (!navType.includes("back_forward")) {
        // Select all toast elements
        const toasts = document.querySelectorAll('.toast');

        toasts.forEach(toast => {
            // Make sure the toast is visible
            toast.style.display = 'block';

            // Hide the toast after 3 seconds with a fade-out transition
            setTimeout(() => {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';

                // Remove the toast from the DOM after the transition
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        });
    } else {
        // If the navigation is back/forward, remove all toasts to avoid flickering
        document.querySelectorAll('.toast').forEach(t => t.remove());
    }
});
