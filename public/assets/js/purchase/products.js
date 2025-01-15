import { products, renderTable, calculateTotals } from './table.js';

export function addProduct() {
    const providerId = document.getElementById('provider_id').value;
    const productId = document.getElementById('product_id').value;
    const price = parseFloat(document.getElementById('price').value);
    const quantity = parseInt(document.getElementById('quantity').value);

    if (!providerId || !productId || isNaN(price) || isNaN(quantity) || quantity <= 0 || price <= 0) {
        Swal.fire('Error', 'Por favor complete todos los campos correctamente.', 'error');
        return;
    }

    const productName = document.querySelector(`#product_id option[value="${productId}"]`).textContent;

    const product = {
        id: productId,
        name: productName,
        price,
        quantity,
        subtotal: price * quantity,
    };

    products.push(product);
    renderTable();
    calculateTotals();
}
