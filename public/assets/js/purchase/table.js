export let products = []; // Array global de productos

// Inicializar la tabla
export function initializeTable() {
    renderTable();
    calculateTotals();
}

// Renderizar la tabla
export function renderTable() {
    const tbody = document.querySelector('tbody');
    tbody.innerHTML = ''; // Limpia la tabla

    products.forEach((product, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <button class="btn btn-danger btn-sm" type="button">Eliminar</button>
            </td>
            <td class="align-middle text-center text-sm">${product.name}</td>
            <td class="align-middle text-center text-sm">PEN ${product.price.toFixed(2)}</td>
            <td class="align-middle text-center text-sm">${product.quantity}</td>
            <td class="text-center text-xxs font-weight-bolder">${product.size.name}</td> <!-- Acceder al nombre -->
            <td class="align-middle text-center text-sm">PEN ${product.subtotal.toFixed(2)}</td>
        `;
        tbody.appendChild(row);

        // Agrega el evento click al botón "Eliminar"
        const deleteButton = row.querySelector('button');
        deleteButton.addEventListener('click', () => {
            removeProduct(index);
        });
    });
}



// Calcular totales
export function calculateTotals() {
    const total = products.reduce((sum, product) => sum + product.subtotal, 0);
    const taxRate = parseFloat(document.getElementById('tax').value) / 100;
    const tax = total * taxRate;
    const totalPayable = total + tax;

    document.getElementById('total').textContent = `PEN ${total.toFixed(2)}`;
    document.getElementById('total_impuesto').textContent = `PEN ${tax.toFixed(2)}`;
    document.getElementById('total_pagar_html').textContent = `PEN ${totalPayable.toFixed(2)}`;
}

// Eliminar producto
export function removeProduct(index) {
    products.splice(index, 1); // Elimina el producto de la lista
    renderTable(); // Vuelve a renderizar la tabla
    calculateTotals(); // Recalcula los totales
}

