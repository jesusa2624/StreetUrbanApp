document.addEventListener("DOMContentLoaded", function () {
    let chartInstance = null; // Variable para almacenar la instancia del gráfico

    // 🔹 Obtener compras del mes actual
    fetch("/purchases/current-month")
        .then(response => response.json())
        .then(data => {

            let totalSpent = parseFloat(data.total_spent) || 0.00;
            let totalPurchases = data.total_purchases || 0;

            // Verificar si los elementos existen antes de actualizar el DOM
            let totalElement = document.querySelector(".compras-total");
            let mesElement = document.querySelector(".compras-mes");
            let textoElement = document.querySelector(".compras-texto");

            if (totalElement) totalElement.innerHTML = `PEN S/ ${totalSpent.toLocaleString('es-PE', { minimumFractionDigits: 2 })}`;
            if (mesElement) mesElement.innerHTML = `Compras de ${new Date().toLocaleString('es-ES', { month: 'long' })}`;
            if (textoElement) textoElement.innerHTML = `Compras: (${totalPurchases})`;
        })
        .catch(error => console.error("Error al obtener compras del mes:", error));

    // 🔹 Obtener compras por mes (gráfico)
    fetch("/purchases/monthly")
        .then(response => response.json())
        .then(data => {

            // Convertir los meses correctamente al español
            let months = data.map(item => {
                let [year, month] = item.month.split("-");
                return new Date(year, parseInt(month, 10) - 1, 1).toLocaleString('es-ES', { month: 'long' });
            });

            let totals = data.map(item => parseFloat(item.total_spent));

            // 🔹 Función para generar un color base aleatorio y usarlo con diferentes opacidades
            function getRandomColor() {
                const r = Math.floor(Math.random() * 256);
                const g = Math.floor(Math.random() * 256);
                const b = Math.floor(Math.random() * 256);
                return { base: `rgba(${r}, ${g}, ${b}`, fill: `rgba(${r}, ${g}, ${b}, 0.8)`, border: `rgba(${r}, ${g}, ${b}, 1)` };
            }

            // Generar colores para cada barra
            let colors = totals.map(() => getRandomColor());
            let backgroundColors = colors.map(color => color.fill);
            let borderColors = colors.map(color => color.border);

            // Verificar si el canvas existe antes de crear el gráfico
            const compraCanvas = document.getElementById('chart_compras');
            if (!compraCanvas) {
                console.error("Elemento #chart_compras no encontrado.");
                return;
            }

            const compra = compraCanvas.getContext('2d');

            // 🔹 Destruir el gráfico anterior antes de crear uno nuevo
            if (chartInstance) {
                chartInstance.destroy();
            }

            chartInstance = new Chart(compra, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Total Gastado (PEN S/)',
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
        .catch(error => console.error("Error al obtener compras por mes:", error));
});
