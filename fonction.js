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

// Bar Chart for User Distribution
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
