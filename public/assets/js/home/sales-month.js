document.addEventListener("DOMContentLoaded", function () {
    let chartInstance = null; // Variable para almacenar el gráfico y evitar errores al actualizar

    // 🔹 Obtener ventas del mes actual
    fetch("/sales/current-month")
        .then(response => response.json())
        .then(data => {
        
            let totalSales = parseFloat(data.total_sales) || 0.00;
            let totalTransactions = data.total_transactions || 0;

            document.querySelector(".ventas-total").innerHTML = `PEN S/ ${totalSales.toLocaleString('es-PE', { minimumFractionDigits: 2 })}`;
            document.querySelector(".ventas-mes").innerHTML = `Ventas de ${new Date().toLocaleString('es-ES', { month: 'long' })}`;
            document.querySelector(".ventas-cantidad").innerHTML = `Ventas: (${totalTransactions})`;
        })
        .catch(error => console.error("Error al obtener ventas del mes:", error));

    // 🔹 Obtener ventas por mes (gráfico)
    fetch("/sales/monthly")
        .then(response => response.json())
        .then(data => {
            
            let months = data.map(item => {
                let [year, month] = item.month.split("-"); // Extraer año y mes
                month = parseInt(month, 10) - 1; // Convertir a índice (0-11)
                return new Date(year, month, 1).toLocaleString('es-ES', { month: 'long' });
            });

            let totals = data.map(item => parseFloat(item.total_sales));

            // Generar colores aleatorios
            function getRandomColor(alpha = 0.8) {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            }

            let backgroundColors = totals.map(() => getRandomColor(0.8));
            let borderColors = backgroundColors.map(color => color.replace("0.8", "1")); // Bordes más intensos

            // 🔹 Verificar si el canvas existe antes de renderizar el gráfico
            const ventasCanvas = document.getElementById('chart_ventas');
            if (!ventasCanvas) {
                console.error("Elemento #chart_ventas no encontrado.");
                return;
            }

            const ventasCtx = ventasCanvas.getContext('2d');

            // 🔹 Destruir gráfico existente antes de crear uno nuevo
            if (chartInstance) {
                chartInstance.destroy();
            }

            chartInstance = new Chart(ventasCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Total Vendido (PEN S/)',
                        data: totals,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        })
        .catch(error => console.error("Error al obtener ventas por mes:", error));
});
