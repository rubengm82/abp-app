class TopBarClock {
    constructor(elementId = 'current-time', updateInterval = 1000) {
        this.element = document.getElementById(elementId);
        this.updateInterval = updateInterval;

        if (!this.element) {
            console.warn(`Elemento con id="${elementId}" no encontrado.`);
            return;
        }

        this.updateTime();

        setInterval(() => this.updateTime(), this.updateInterval);
    }

    // padStart se usa para poner ceros delante de la hora
    formatTime(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        return `${month}/${day}/${year} ${hours}:${minutes}:${seconds}`;
    }

    updateTime() {
        const now = new Date();
        this.element.textContent = this.formatTime(now);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new TopBarClock('current-time');
});
