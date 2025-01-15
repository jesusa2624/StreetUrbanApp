export let products = []; // Array global de productos

// Inicializar la tabla
export function initializeTable() {
    console.log('Tabla inicializada');
    renderTable();
    calculateTotals();
}

// Renderizar la tabla
export function renderTable() {
    const tbody = document.querySelector('tbody');
    tbody.innerHTML = ''; // Limpiar la tabla

    products.forEach((product, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <button class="btn btn-danger btn-sm" onclick="removeProduct(${index})">Eliminar</button>
            </td>
            <td>${product.name}</td>
            <td>PEN ${product.price.toFixed(2)}</td>
            <td>${product.quantity}</td>
            <td>PEN ${product.subtotal.toFixed(2)}</td>
        `;
        tbody.appendChild(row);
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
    products.splice(index, 1);
    renderTable();
    calculateTotals();
}
