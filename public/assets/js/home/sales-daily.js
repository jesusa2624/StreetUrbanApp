document.addEventListener("DOMContentLoaded", function () {
    fetch("/sales/daily")
        .then(response => response.json())
        .then(data => {
            console.log("Ventas diarias:", data);

            const labels = data.map(sale => sale.date); // Ya está en formato DD-MM-YYYY
            const salesData = data.map(sale => parseFloat(sale.total_sales));

            const ctx = document.getElementById('chart_ventas_diarias').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(255, 120, 64, 0.8)');
            gradient.addColorStop(1, 'rgba(255, 206, 86, 0.8)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas Diarias',
                        data: salesData,
                        backgroundColor: gradient,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(255, 159, 64, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#555' }
                        },
                        y: {
                            grid: {
                                drawBorder: false,
                                color: 'rgba(200, 200, 200, 0.3)'
                            },
                            ticks: {
                                color: '#555',
                                stepSize: 50
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error("Error al obtener ventas diarias:", error));
});
