let isEditMode = false;

// Función para abrir el modal en modo "Crear"
function abrirModalCrear() {
    isEditMode = false;
    document.getElementById('modalNuevoClienteLabel').innerText = 'Registro de Cliente';
    document.getElementById('formNuevoCliente').reset();
    document.getElementById('idCliente').value = '';
    const modal = new bootstrap.Modal(document.getElementById('modalNuevoCliente'));
    modal.show();
}

// Función para abrir el modal en modo "Editar"
function abrirModalEditar(id) {
    isEditMode = true;
    document.getElementById('modalNuevoClienteLabel').innerText = 'Editar Cliente';

    fetch(`/clients/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('idCliente').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('dni').value = data.dni;
            document.getElementById('ruc').value = data.ruc;
            document.getElementById('phone').value = data.phone;
            document.getElementById('address').value = data.address;
            document.getElementById('email').value = data.email;
            const modal = new bootstrap.Modal(document.getElementById('modalNuevoCliente'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al obtener los datos del cliente:', error);
            alert('Hubo un problema al cargar los datos del cliente.');
        });
}
