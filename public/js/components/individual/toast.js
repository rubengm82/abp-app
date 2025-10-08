/* SELECT ALL TOASTS AND AUTOMATICALLY CLOSE THEM AFTER 3 SECONDS */
document.addEventListener('DOMContentLoaded', function () {
    // Select all toasts
    const toasts = document.querySelectorAll('.toast');

    toasts.forEach(toast => {
        // Show the toast
        toast.style.display = 'block';

        // Hide after 3 seconds with opacity transition
        setTimeout(() => {
            toast.style.transition = 'opacity 0.5s ease';
            toast.style.opacity = '0';

            // Remove from the DOM after the transition
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    });
});

