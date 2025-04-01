document.addEventListener('DOMContentLoaded', () => {
    // Cargar proveedores
    axios.get('/providers/getProviders')
        .then(response => {
            if (!Array.isArray(response.data)) {
                throw new Error('La respuesta de proveedores no es un arreglo');
            }

            const providerSelect = document.getElementById('provider_id');
            providerSelect.innerHTML = `
                <option value="" disabled selected>Seleccione el Proveedor...</option>
            `;
            providerSelect.innerHTML += response.data.map(provider => `
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
            productSelect.innerHTML = `
                <option value="" disabled selected>Seleccione el Producto...</option>
            `;
            productSelect.innerHTML += response.data.map(product => `
                <option value="${product.id}">${product.name}</option>
            `).join('');
        })
        .catch(error => console.error('Error al cargar productos:', error));

    
    // Cargar tallas
    axios.get('/sizes/getSizes')
        .then(response => {
            if (!Array.isArray(response.data)) {
                throw new Error('La respuesta de tallas no es un arreglo');
            }

            const sizeSelect = document.getElementById('size_id');
            sizeSelect.innerHTML = `
                <option value="" disabled selected>Seleccione la Talla...</option>
            `;
            sizeSelect.innerHTML += response.data.map(size => `
                <option value="${size.id}">${size.name}</option>
            `).join('');
        })
        .catch(error => console.error('Error al cargar tallas:', error));
});
