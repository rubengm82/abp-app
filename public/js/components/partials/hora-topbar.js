function updateTime() {
    const now = new Date();
    // Format date and time with leading zeros
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = `${month}/${day}/${year} ${hours}:${minutes}:${seconds}`;
    }
}

// Update every second
setInterval(updateTime, 1000);
// Call once on load
updateTime();
