document.getElementById('submitForm').addEventListener('click', function () {
    const id = document.getElementById('idCliente').value;
    const name = document.getElementById('name').value;
    const dni = document.getElementById('dni').value;
    const ruc = document.getElementById('ruc').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;
    const email = document.getElementById('email').value;

    const isEdit = id !== ''; // Si hay un ID, es edición

    const url = isEdit ? `/clients/${id}` : '/clients';
    const method = isEdit ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ name, dni, ruc, phone, address, email }),
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw err;
                });
            }
            return response.json();
        })
        .then(client => {
            Swal.fire({
                title: isEdit ? '¡Actualización exitosa!' : '¡Registro exitoso!',
                text: isEdit
                    ? 'El cliente fue actualizado correctamente.'
                    : 'El cliente fue registrado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar',
            }).then(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoCliente'));
                modal.hide(); // Cierra el modal
        
                // Recargar la tabla para reflejar cambios
                cargarClientes();
            });
        })        
        .catch(error => {
            console.error('Error:', error);
            let errorMessage = 'Hubo un problema al procesar la solicitud.';

            if (error.errors) {
                if (error.errors.dni) {
                    errorMessage = error.errors.dni[0];
                } else if (error.errors.ruc) {
                    errorMessage = error.errors.ruc[0];
                }
            }

            Swal.fire({
                title: '¡Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'Aceptar',
            });
        });
});

// Función para actualizar la tabla sin recargar
function actualizarTabla(client, isEdit) {
    const tabla = document.getElementById('tablaClientes'); // Asegúrate de que tienes una tabla con este ID
    if (!tabla) return;

    if (isEdit) {
        // Buscar y actualizar fila existente
        const fila = document.querySelector(`#cliente-${client.id}`);
        if (fila) {
            fila.innerHTML = `
                <td>${client.name}</td>
                <td>${client.dni}</td>
                <td>${client.ruc}</td>
                <td>${client.phone}</td>
                <td>${client.address}</td>
                <td>${client.email}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="abrirModalEditar(${client.id})">Editar</button>
                </td>
            `;
        }
    } else {
        // Agregar nueva fila
        const nuevaFila = document.createElement('tr');
        nuevaFila.id = `cliente-${client.id}`;
        nuevaFila.innerHTML = `
            <td>${client.name}</td>
            <td>${client.dni}</td>
            <td>${client.ruc}</td>
            <td>${client.phone}</td>
            <td>${client.address}</td>
            <td>${client.email}</td>
            <td>
                <button class="btn btn-primary btn-sm" onclick="abrirModalEditar(${client.id})">Editar</button>
            </td>
        `;
        tabla.appendChild(nuevaFila);
    }
}
