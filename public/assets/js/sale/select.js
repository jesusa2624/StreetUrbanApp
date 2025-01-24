document.addEventListener('DOMContentLoaded', () => {
    // Cargar clientes
    axios.get('/clients/getClients')
        .then(response => {
            if (!Array.isArray(response.data)) {
                throw new Error('La respuesta de clientes no es un arreglo');
            }

            const clientSelect = document.getElementById('client_id');
            clientSelect.innerHTML = `
                <option value="" disabled selected>Seleccione el Cliente...</option>
            ` + response.data.map(client => `
                <option value="${client.id}">${client.name}</option>
            `).join('');
        })
        .catch(error => console.error('Error al cargar clientes:', error));

    // Cargar productos
    axios.get('/products/getProducts')
        .then(response => {
            if (!Array.isArray(response.data)) {
                throw new Error('La respuesta de productos no es un arreglo');
            }

            const productSelect = document.getElementById('product_id');
            const stockInput = document.getElementById('stock');
            const barcodeInput = document.getElementById('code');
            const priceInput = document.getElementById('price');

            // Deshabilitar campos inicialmente
            stockInput.disabled = true;
            barcodeInput.disabled = true;
            priceInput.disabled = true;

            // Rellenar el select de productos con data-stock
            productSelect.innerHTML = `
                <option value="" disabled selected>Seleccione el Producto...</option>
            ` + response.data.map(product => `
                <option value="${product.id}" data-stock="${product.stock}">
                    ${product.name}
                </option>
            `).join('');

            // Agregar evento para actualizar los campos al cambiar el producto
            productSelect.addEventListener('change', () => {
                const selectedOption = productSelect.options[productSelect.selectedIndex];

                if (!selectedOption.value) {
                    // Si no hay producto seleccionado, limpiar los campos
                    stockInput.value = '';
                    barcodeInput.value = '';
                    priceInput.value = '';
                    return;
                }

                // Obtener el stock y otros detalles del producto directamente del atributo data-stock
                const stock = selectedOption.dataset.stock;
                const productId = selectedOption.value;

                // Actualizar campos con los datos del producto
                axios.get(`/products/${productId}/details`)
                    .then(productResponse => {
                        const product = productResponse.data;

                        stockInput.value = stock; // Stock del atributo data-stock
                        barcodeInput.value = product.code;
                        priceInput.value = product.sell_price;
                    })
                    .catch(error => {
                        console.error('Error al obtener los detalles del producto:', error);
                        Swal.fire('Error', 'No se pudieron cargar los detalles del producto.', 'error');
                    });
            });
        })
        .catch(error => console.error('Error al cargar productos:', error));
});
