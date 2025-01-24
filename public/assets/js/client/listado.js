window.cargarClientes = async function () {
    try {
        // Realiza la solicitud al servidor
        const response = await fetch(clientsJsonUrl, {
            headers: {
                'Accept': 'application/json', // Garantiza que se solicite JSON
            },
        });

        // Verifica que la respuesta sea válida
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        // Convierte la respuesta en JSON
        const clients = await response.json();

        // Selecciona el cuerpo de la tabla
        const tbody = document.querySelector('tbody');
        if (!tbody) throw new Error('No se encontró el elemento <tbody> en el DOM.');

        // Limpia el contenido anterior de la tabla
        tbody.innerHTML = '';

        // Itera sobre los clientes y genera las filas
        clients.forEach((client) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="text-center text-xxs font-weight-bolder">${client.id}</td>
                <td class="text-center text-xxs font-weight-bolder">${client.name || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${client.dni || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${client.phone || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">${client.email || '-'}</td>
                <td class="text-center text-xxs font-weight-bolder">
                    <button type="button" class="btn btn-secondary" onclick="abrirModalEditar(${client.id})">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="borrarCliente(${client.id})">Borrar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error('Error al cargar los clientes:', error);
        alert('Hubo un error al cargar los clientes. Por favor, intenta nuevamente.');
    }
};

// Ejecuta la función al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    cargarClientes();
});
