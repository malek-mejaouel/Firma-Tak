const incomeCtx = document.getElementById('incomeChart').getContext('2d');
const incomeChart = new Chart(incomeCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Income ($)',
            data: [3000, 3200, 3400, 3600, 3900, 4100, 4200, 4500, 4800, 5000, 5300, 5600],
            borderColor: '#0eb941',
            backgroundColor: 'rgba(14, 185, 65, 0.2)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
const userCtx = document.getElementById('userChart').getContext('2d');
const userChart = new Chart(userCtx, {
    type: 'bar',
    data: {
        labels: ['Farmers', 'Grocers'],
        datasets: [{
            label: 'User Count',
            data: [2194, 53],
            backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(255, 99, 132, 0.7)'],
            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
// Event Search Functionality
document.getElementById('searchBtn').addEventListener('click', function() {
    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
    const events = document.querySelectorAll('.post-box'); // Assuming events are displayed in elements with class 'post-box'

    events.forEach(function(event) {
        const title = event.querySelector('.category').textContent.toLowerCase();
        const description = event.querySelector('.post-date').textContent.toLowerCase();

        if (title.includes(searchQuery) || description.includes(searchQuery)) {
            event.style.display = ''; // Show matching events
        } else {
            event.style.display = 'none'; // Hide non-matching events
        }
    });
});

// Join Event Functionality
function joinEvent(eventId) {
    const participantName = prompt("Enter your name to join the event:");
    const participantEmail = prompt("Enter your email:");
    if (participantName && participantEmail) {
        fetch('joinEvent.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                event_id: eventId,
                name: participantName,
                email: participantEmail
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert("Successfully joined the event!");
                location.reload(); // Refresh to update participant list
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => console.error("Error:", error));
    }
}



