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

// Función para buscar datos por DNI utilizando ConsultasPeru
function buscarPorDNI() {
    const dni = document.getElementById('dni').value.trim();

    if (!dni || dni.length !== 8 || isNaN(dni)) {
        Swal.fire('Error', 'Ingrese un DNI válido de 8 dígitos.', 'error');
        return;
    }

    fetch(`/buscar-dni/${dni}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.nombre) {
                document.getElementById('name').value = data.nombre;
                Swal.fire('Éxito', 'Datos encontrados correctamente.', 'success');
            } else {
                Swal.fire('Error', 'No se encontraron datos para este DNI.', 'error');
            }
        })
        .catch(error => {
            console.error('Error al consultar el DNI:', error);
            Swal.fire('Error', 'Hubo un problema al consultar los datos.', 'error');
        });
}

// Asociar la función al botón
document.addEventListener('DOMContentLoaded', () => {
    const searchDniButton = document.getElementById('searchDni');
    if (searchDniButton) {
        searchDniButton.addEventListener('click', buscarPorDNI);
    }
});
