import { cambiarEstadoVenta } from './status.js'; // Cambiar estado
import { verVenta } from './verVenta.js'; // Ver detalles de venta

export function cargarVentas() {
    const tbody = document.querySelector('.table-responsive-principal tbody');

    axios.get('/sales/getSales')
        .then(response => {
            const sales = response.data;

            tbody.innerHTML = ''; // Limpia el contenido del tbody

            sales.forEach(sale => {
                const productsList = sale.products.map(product => 
                    `${product.product_name} (${product.quantity})`
                ).join(', ');

                // Crear fila para cada venta
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="text-center text-xxs font-weight-bolder">${sale.id}</td>
                    <td class="text-center text-xxs font-weight-bolder">${sale.client_name}</td>
                    <td class="text-center text-xxs font-weight-bolder">
                        <button class="btn estado-btn">
                            ${sale.status === 'VALID' ? 'Activo' : 'Cancelado'}
                            <i class="fas ${sale.status === 'VALID' ? 'fa-check' : 'fa-times'}"></i>
                        </button>
                    </td>
                    <td class="text-center text-xxs font-weight-bolder">PEN ${sale.total.toFixed(2)}</td>
                    <td class="text-center text-xxs font-weight-bolder">
                        <button class="btn btn-warning ver-btn">
                            <i class="fa-solid fa-file-invoice fa-2x"></i>
                        </button>
                    </td>
                `;

                tbody.appendChild(row);

                // Configurar el botón de cambiar estado
                const estadoBtn = row.querySelector('.estado-btn');
                estadoBtn.className = `btn ${sale.status === 'VALID' ? 'btn-success' : 'btn-danger'}`;
                estadoBtn.addEventListener('click', () => cambiarEstadoVenta(sale.id));

                // Configurar el botón de ver venta
                const verBtn = row.querySelector('.ver-btn');
                verBtn.addEventListener('click', () => verVenta(sale.id));
            });
        })
        .catch(error => {
            console.error('Error al cargar las ventas:', error);
            Swal.fire('Error', 'No se pudieron cargar las ventas.', 'error');
        });
}
