document.addEventListener('DOMContentLoaded', () => {
    const productTableBody = document.querySelector('tbody'); // Cuerpo de la tabla
    const totalSpan = document.getElementById('total'); // Total sin impuesto
    const taxSpan = document.getElementById('total_impuesto'); // Impuesto
    const totalPayableSpan = document.getElementById('total_pagar_html'); // Total a pagar
    const taxInput = document.getElementById('tax'); // Impuesto porcentual
    const addButton = document.getElementById('submitForm'); // Botón agregar producto
    const saveButton = document.getElementById('savePurchase'); // Botón guardar compra

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    if (csrfToken) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    } else {
        console.error('Token CSRF no encontrado.');
    }



    // Array para almacenar los productos añadidos
    let products = [];

    // Función para calcular los totales
    function calculateTotals() {
        let total = 0;

        // Suma los subtotales de todos los productos
        products.forEach(product => {
            total += product.subtotal;
        });

        const taxRate = parseFloat(taxInput.value) / 100; // Convierte el impuesto en porcentaje
        const tax = total * taxRate;
        const totalPayable = total + tax;

        // Actualiza los elementos del DOM
        totalSpan.textContent = `PEN ${total.toFixed(2)}`;
        taxSpan.textContent = `PEN ${tax.toFixed(2)}`;
        totalPayableSpan.textContent = `PEN ${totalPayable.toFixed(2)}`;
    }

    // Función para renderizar la tabla
    function renderTable() {
        productTableBody.innerHTML = ''; // Limpia la tabla

        // Agrega cada producto al cuerpo de la tabla
        products.forEach((product, index) => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="text-center text-xxs font-weight-bolder">
                    <button class="btn btn-danger btn-sm" onclick="removeProduct(${index})">Eliminar</button>
                </td>
                <td class="text-center text-xxs font-weight-bolder">${product.name}</td>
                <td class="text-center text-xxs font-weight-bolder">PEN ${product.price.toFixed(2)}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.quantity}</td>
                <td class="text-center text-xxs font-weight-bolder">PEN ${product.subtotal.toFixed(2)}</td>
            `;

            productTableBody.appendChild(row);
        });
    }

    // Función para eliminar un producto por índice
    window.removeProduct = (index) => {
        products.splice(index, 1); // Elimina el producto del array
        renderTable(); // Vuelve a renderizar la tabla
        calculateTotals(); // Recalcula los totales
    };

    // Evento de clic para agregar un producto
    addButton.addEventListener('click', () => {
        const providerId = document.getElementById('provider_id').value;
        const productId = document.getElementById('product_id').value;
        const price = parseFloat(document.getElementById('price').value);
        const quantity = parseInt(document.getElementById('quantity').value);

        // Validación básica
        if (!providerId || !productId || isNaN(price) || isNaN(quantity) || quantity <= 0 || price <= 0) {
            alert('Por favor, complete todos los campos correctamente.');
            return;
        }

        // Obtener el nombre del producto para mostrar (puede ser modificado según la lógica)
        const productName = document.querySelector(`#product_id option[value="${productId}"]`).textContent;

        // Crear el producto y agregarlo al array
        const product = {
            id: productId,
            name: productName,
            price,
            quantity,
            subtotal: price * quantity
        };

        products.push(product); // Agregar al array de productos
        renderTable(); // Renderizar la tabla con el nuevo producto
        calculateTotals(); // Recalcular los totales
    });

    // Evento de clic para guardar la compra
    saveButton.addEventListener('click', () => {
        const providerId = document.getElementById('provider_id').value;
        const tax = parseFloat(taxInput.value);

        if (!providerId || products.length === 0) {
            alert('Por favor, complete todos los campos y agregue al menos un producto.');
            return;
        }

        // Preparar los datos para enviar al backend
        const purchaseData = {
            provider_id: providerId,
            tax: tax,
            products: products.map(product => ({
                product_id: product.id,
                price: product.price,
                quantity: product.quantity,
            }))
        };
        console.log('Datos enviados:', purchaseData);

        // Enviar los datos al backend
        axios.post('/purchases', purchaseData)
            .then(response => {
                Swal.fire('Éxito', response.data.message, 'success');
                products = [];
                renderTable();
                calculateTotals();
                document.getElementById('formNuevoPurchase').reset();
            })
            .catch(error => {
                console.error('Error completo:', error);
                console.error('Error de respuesta:', error.response); // Detalles de la respuesta del servidor
                Swal.fire('Error', error.response?.data?.message || 'Ocurrió un error.', 'error');
            });

    });
});
