window.cargarClientes = async function () {
    try {
        const response = await fetch(clientsJsonUrl, {
            headers: { 'Accept': 'application/json' }
        });

        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const clients = await response.json();
        const tbody = document.querySelector('tbody');
        if (!tbody) throw new Error('No se encontró el elemento <tbody> en el DOM.');

        // Verificar si DataTable ya está inicializado y destruirlo antes de volver a llenarlo
        if ($.fn.DataTable.isDataTable('#clientesTabla')) {
            $('#clientesTabla').DataTable().destroy();
        }

        tbody.innerHTML = ''; // Limpiar la tabla antes de cargar nuevos datos

        clients.forEach((client) => {
            agregarClienteATabla(client);
        });

        // Re-inicializar DataTable después de cargar los datos
        $('#clientesTabla').DataTable({
            destroy: true, // Permite recargar la tabla sin problemas
            responsive: true,
            order: [[0, 'desc']],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

    } catch (error) {
        console.error('Error al cargar los clientes:', error);
        alert('Hubo un error al cargar los clientes. Por favor, intenta nuevamente.');
    }
};

// Función para agregar un cliente a la tabla sin recargar la página
function agregarClienteATabla(client) {
    const tbody = document.querySelector('tbody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td class="text-center text-xxs font-weight-bolder">${client.id}</td>
        <td class="text-center text-xxs font-weight-bolder">${client.name || '-'}</td>
        <td class="text-center text-xxs font-weight-bolder">${client.dni || '-'}</td>
        <td class="text-center text-xxs font-weight-bolder">${client.phone || '-'}</td>
        <td class="text-center text-xxs font-weight-bolder">${client.email || '-'}</td>
        <td class="text-center text-xxs font-weight-bolder">
            <button class="btn btn-secondary" onclick="abrirModalEditar(${client.id})">Editar</button>
            <button class="btn btn-danger" onclick="borrarCliente(${client.id})">Borrar</button>
        </td>
    `;

    tbody.appendChild(row);
}

// Cargar los clientes cuando la página se haya cargado completamente
document.addEventListener('DOMContentLoaded', () => {
    cargarClientes();
});
