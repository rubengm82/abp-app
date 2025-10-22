// RESET --> COLLAPSE ALL MENU

document.addEventListener("DOMContentLoaded", () => {
    
    // Delete keys that start with 'menu-detail-
    Object.keys(localStorage).forEach(key => {
        if (key.startsWith("menu-detail-")) {
            localStorage.removeItem(key);
        }
    });

    const detailsElements = document.querySelectorAll("details");

    detailsElements.forEach((detail, index) => {
        const key = `menu-detail-${index}`;
        detail.open = false;

        detail.addEventListener("toggle", () => {
            localStorage.setItem(key, detail.open);
        });
    });
    
});