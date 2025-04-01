window.cargarProducts = async function () {
    try {
        // Realiza la solicitud al servidor
        const response = await fetch(productsJsonUrl, {
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const products = await response.json();
        const tbody = document.querySelector('tbody');
        if (!tbody) throw new Error('No se encontró el elemento <tbody> en el DOM.');

        // 🔹 Destruir DataTables antes de modificar el contenido
        if ($.fn.DataTable.isDataTable('#productosTable')) {
            $('#productosTable').DataTable().clear().destroy();
        }

        // 🔹 Limpiar la tabla
        tbody.innerHTML = '';

        // 🔹 Insertar los nuevos productos
        products.forEach((product, index) => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="text-center text-xxs font-weight-bolder">${index + 1}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.name || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.stock || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.status || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${product.category ? product.category.name : '-'}</td>
                <td class="text-center">
                    ${product.image ? `<img src="${product.image}" alt="${product.name}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">` : '-'}
                </td>
                <td class="align-middle text-center">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="abrirModalEditar(${product.id})">Editar</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="borrarProducto(${product.id})">Borrar</button>
                </td>
            `;
            tbody.appendChild(row);
        });

        // 🔹 Volver a inicializar DataTables **después** de insertar las filas
        $('#productosTable').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [[0, 'desc']]
        });

    } catch (error) {
        console.error('Error al cargar los productos:', error);
        alert('Hubo un error al cargar los productos. Por favor, intenta nuevamente.');
    }
};

// 🔹 Ejecutar la función al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    cargarProducts();
});

// 🔹 Volver a cargar productos cuando se cierra el modal
$('#modalAgregarProducto').on('hidden.bs.modal', function () {
    cargarProducts();
});
