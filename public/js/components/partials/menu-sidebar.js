document.addEventListener("DOMContentLoaded", () => {
    const detailsElements = document.querySelectorAll("details");

    detailsElements.forEach((detail, index) => {
        const key = `menu-detail-${index}`;

        // Leer estado guardado en localStorage
        const savedState = localStorage.getItem(key);

        if (savedState !== null) {
            detail.open = savedState === "true";
        } else {
            // Primera vez: todo cerrado
            detail.open = false;
        }

        // Escuchar cambios de estado
        detail.addEventListener("toggle", () => {
            localStorage.setItem(key, detail.open);
        });
    });
});