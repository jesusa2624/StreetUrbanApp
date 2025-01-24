import { cambiarEstadoCompra } from './status.js'; // Importar la función de cambiar estado
import { verCompra } from './verCompra.js'; // Importar la función de ver compra

export function cargarCompras() {
    const tbody = document.querySelector('.table-responsive-principal tbody'); // Selecciona el <tbody> correcto

    if (!tbody) {
        console.error('El <tbody> especificado no se encuentra en el DOM.');
        return;
    }

    axios.get('/purchases/getPurchases')
        .then(response => {
            const purchases = response.data;

            tbody.innerHTML = ''; // Limpia el contenido actual del <tbody>

            purchases.forEach(purchase => {
                if (!purchase.products || !Array.isArray(purchase.products)) {
                    console.warn(`Productos inválidos para la compra con ID: ${purchase.id}`);
                    return;
                }

                // Crear una fila para la tabla
                const row = createRow(purchase);
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error al cargar las compras:', error);
            Swal.fire('Error', 'No se pudieron cargar las compras.', 'error');
        });
}

function createRow(purchase) {
    // Combina los productos en una sola cadena
    const productsList = purchase.products.map(product =>
        `${product.product_name} (${product.quantity})`
    ).join(', ');

    // Crear una fila de tabla
    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="text-center text-xxs font-weight-bolder">${purchase.id}</td>
        <td class="text-center text-xxs font-weight-bolder">${productsList}</td>
        <td class="text-center text-xxs font-weight-bolder">
            <button class="btn btn-success estado-btn">
                Activo <i class="fas fa-check"></i>
            </button>
        </td>
        <td class="text-center text-xxs font-weight-bolder">PEN ${purchase.total}</td>
        <td class="text-center text-xxs font-weight-bolder">
            <button class="btn btn-warning ver-btn">
                <i class="fa-solid fa-file-invoice fa-2x"></i>
            </button>
        </td>
    `;

    // Configurar el botón de cambiar estado
    const estadoBtn = row.querySelector('.estado-btn');
    estadoBtn.textContent = purchase.status === 'VALID' ? 'Activo' : 'Cancelado';
    estadoBtn.className = `btn ${purchase.status === 'VALID' ? 'btn-success' : 'btn-danger'}`;
    estadoBtn.innerHTML += ` <i class="fas ${purchase.status === 'VALID' ? 'fa-check' : 'fa-times'}"></i>`;
    estadoBtn.addEventListener('click', () => cambiarEstadoCompra(purchase.id));

    // Configurar el botón de ver compra
    const verBtn = row.querySelector('.ver-btn');
    verBtn.addEventListener('click', () => verCompra(purchase.id));

    return row;
}
