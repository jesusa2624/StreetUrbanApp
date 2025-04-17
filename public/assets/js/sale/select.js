document.addEventListener('DOMContentLoaded', () => {
    let productsData = []; // Aquí guardamos los productos una vez cargados

    // Cargar clientes
    axios.get('/clients/getClients')
        .then(response => {
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

            productsData = response.data;
            console.log('Productos con tallas y stock por talla:', productsData); // 👈 LOG DE DEPURACIÓN

            const productSelect = document.getElementById('product_id');
            const stockInput = document.getElementById('stock');
            const barcodeInput = document.getElementById('code');
            const priceInput = document.getElementById('price');
            const sizeSelect = document.getElementById('size');

            stockInput.disabled = true;
            barcodeInput.disabled = true;
            priceInput.disabled = true;
            sizeSelect.disabled = true;

            productSelect.innerHTML = `
                <option value="" disabled selected>Seleccione el Producto...</option>
            ` + productsData.map(product => `
                <option value="${product.id}">
                    ${product.name}
                </option>
            `).join('');

            // Evento de cambio en el producto
            productSelect.addEventListener('change', () => {
                const productId = parseInt(productSelect.value);
                const selectedProduct = productsData.find(p => p.id === productId);

                if (!selectedProduct) {
                    stockInput.value = '';
                    barcodeInput.value = '';
                    priceInput.value = '';
                    sizeSelect.innerHTML = '<option value="">Seleccione un producto primero</option>';
                    sizeSelect.disabled = true;
                    return;
                }

                // Mostrar código del producto (precio y stock se mostrarán al seleccionar talla)
                barcodeInput.value = selectedProduct.code;
                stockInput.value = '';
                priceInput.value = '';

                // Actualizar tallas disponibles
                if (Array.isArray(selectedProduct.sizes) && selectedProduct.sizes.length > 0) {
                    sizeSelect.innerHTML = `
                        <option value="" disabled selected>Seleccione la Talla...</option>
                    ` + selectedProduct.sizes.map(size => `
                        <option value="${size.id}" data-stock="${size.stock}">
                            ${size.name}
                        </option>
                    `).join('');
                    sizeSelect.disabled = false;
                } else {
                    sizeSelect.innerHTML = '<option value="" disabled selected>No hay tallas disponibles</option>';
                    sizeSelect.disabled = true;
                }
            });

            // Evento de cambio en la talla
            sizeSelect.addEventListener('change', () => {
                const selectedSizeId = parseInt(sizeSelect.value);  // Obtenemos el ID de la talla seleccionada
                const selectedProductId = parseInt(productSelect.value);
                const selectedProduct = productsData.find(p => p.id === selectedProductId);

                if (!selectedSizeId || !selectedProduct) return;

                // Buscar la talla seleccionada en el array de tallas del producto usando el ID de la talla
                const selectedSize = selectedProduct.sizes.find(s => s.id === selectedSizeId);

                if (selectedSize) {
                    stockInput.value = selectedSize.stock ?? '0';  // Asignamos el stock correspondiente
                    priceInput.value = selectedProduct.sell_price;  // Asignamos el precio del producto
                } else {
                    stockInput.value = '';
                    priceInput.value = '';
                }
            });
        })
        .catch(error => console.error('Error al cargar productos:', error));
});
