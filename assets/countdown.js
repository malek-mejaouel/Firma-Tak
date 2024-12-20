document.addEventListener("DOMContentLoaded", () => {
    const countdownElements = document.querySelectorAll(".countdown");

    countdownElements.forEach((element) => {
        const eventDate = new Date(element.getAttribute("data-event-date")).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = eventDate - now;

            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000)) / 1000);

                element.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                element.innerHTML = "Event Started";
            }
        }

        setInterval(updateCountdown, 1000);
    });
});
