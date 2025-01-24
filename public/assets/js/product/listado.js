window.cargarProducts = async function () {
    try {
        // Realiza la solicitud al servidor
        const response = await fetch(productsJsonUrl, {
            headers: {
                'Accept': 'application/json', // Garantiza que se solicite JSON
            },
        });

        // Verifica que la respuesta sea válida
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        // Convierte la respuesta en JSON
        const products = await response.json();

        // Selecciona el cuerpo de la tabla
        const tbody = document.querySelector('tbody');
        if (!tbody) throw new Error('No se encontró el elemento <tbody> en el DOM.');

        // Limpia el contenido anterior de la tabla
        tbody.innerHTML = '';

        // Itera sobre los productos y genera las filas
        products.forEach((product, index) => {
            const row = document.createElement('tr');
            // console.log(pproduct.category ? product.category.name : '-');
            
            row.innerHTML = `
                <td class="text-center text-xxs font-weight-bolder">${index + 1}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.name || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.stock || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.status || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.category.name || '-'}</td
                
                <td class="text-center text-xxs font-weight-bolder">
                    <img src="${product.image}" alt="${product.name}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                </td>

                <td class="align-middle text-center text-sm">
                    <button type="button" class="btn btn-secondary" onclick="abrirModalEditar(${product.id})">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="borrarProducto(${product.id})">Borrar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error('Error al cargar los productos:', error);
        alert('Hubo un error al cargar los productos. Por favor, intenta nuevamente.');
    }
};

// Ejecuta la función al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    cargarProducts();
});