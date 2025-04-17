import { products, renderTable, calculateTotals } from './table.js';

export function addProduct() {
    const productId = document.getElementById('product_id').value;
    const price = parseFloat(document.getElementById('price').value);
    const quantity = parseInt(document.getElementById('quantity').value);
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const sizeId = document.getElementById('size').value;
    console.log('Selected size_id:', sizeId);
    

    // Validar campos básicos
    if (!productId || isNaN(price) || isNaN(quantity) || quantity <= 0 || price <= 0 || !sizeId) {
        Swal.fire('Error', 'Por favor complete todos los campos correctamente, incluyendo la talla.', 'error');
        return;
    }

    // Obtener el stock del producto desde el atributo data-stock
    const stock = parseInt(document.querySelector(`#product_id option[value="${productId}"]`).dataset.stock);

    // Validar stock
    if (stock === 0) {
        Swal.fire('Error', 'Este producto no tiene stock disponible.', 'error');
        return;
    }

    // Validar cantidad frente al stock disponible
    if (quantity > stock) {
        Swal.fire('Error', 'La cantidad excede el stock disponible.', 'error');
        return;
    }

    const productName = document.querySelector(`#product_id option[value="${productId}"]`).textContent;

    const subtotal = price * quantity - discount;

    const product = {
        id: productId,
        name: productName,
        size_id: sizeId, // Agregar el size_id
        price,
        quantity,
        discount,
        subtotal,
    };

    // Agregar producto al listado
    products.push(product);
    renderTable();
    calculateTotals();
}



