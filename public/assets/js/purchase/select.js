document.addEventListener('DOMContentLoaded', () => {
    // Cargar proveedores
    axios.get('/providers/getProviders')
        .then(response => {
            if (!Array.isArray(response.data)) {
                throw new Error('La respuesta de proveedores no es un arreglo');
            }

            const providerSelect = document.getElementById('provider_id');
            providerSelect.innerHTML = response.data.map(provider => `
                <option value="" disabled selected>Seleccione el Proveedor...</option>
                <option value="${provider.id}">${provider.name}</option>
            `).join('');
        })
        .catch(error => console.error('Error al cargar proveedores:', error));

    // Cargar productos
    axios.get('/products/getProducts')
        .then(response => {
            if (!Array.isArray(response.data)) {
                throw new Error('La respuesta de productos no es un arreglo');
            }

            const productSelect = document.getElementById('product_id');
            productSelect.innerHTML = response.data.map(product => `
                <option value="" disabled selected>Seleccione el Producto...</option>
                <option value="${product.id}">${product.name}</option>
            `).join('');
        })
        .catch(error => console.error('Error al cargar productos:', error));
});
