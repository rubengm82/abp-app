/* SELECT ALL TOASTS AND AUTOMATICALLY CLOSE THEM AFTER 3 SECONDS */
document.addEventListener('DOMContentLoaded', function () {
    // Select all toasts
    const toasts = document.querySelectorAll('.toast');

    toasts.forEach(toast => {
        // Show immediately (you can add animation class if you want)
        toast.style.display = 'block';

        // Automatically hide after 3 seconds
        setTimeout(() => {
            // Fade-out animation (optional)
            toast.style.transition = 'opacity 0.5s ease';
            toast.style.opacity = '0';

            // Optional: remove from DOM after the transition
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 3000);
    });
});
