window.cargarProviders = async function () {
    try {
        const response = await fetch(clientsJsonUrl);
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const providers = await response.json();

        const tbody = document.querySelector('tbody');
        if (!tbody) throw new Error('No se encontró el elemento <tbody> en el DOM.');

        // Limpia el contenido anterior de la tabla
        tbody.innerHTML = '';

        // Itera sobre los proveedores y genera las filas
        providers.forEach((provider) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="text-center text-xxs font-weight-bolder">${provider.id}</td>
                <td class="text-center text-xxs font-weight-bolder">${provider.name || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${provider.email || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${provider.phone || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${provider.address || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">
                    <button type="button" class="btn btn-secondary" onclick="abrirModalEditar(${provider.id})">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="borrarProvider(${provider.id})">Borrar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error('Error al cargar los proveedores:', error);
        alert('Hubo un error al cargar los proveedores. Por favor, intenta nuevamente.');
    }
};

document.addEventListener('DOMContentLoaded', () => {
    cargarProviders();
})