document.getElementById('submitForm').addEventListener('click', function () {
    const id = document.getElementById('idCliente').value;
    const name = document.getElementById('name').value;
    const dni = document.getElementById('dni').value;
    const ruc = document.getElementById('ruc').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;
    const email = document.getElementById('email').value;

    const url = isEditMode ? `/clients/${id}` : '/clients';
    const method = isEditMode ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ name, dni, ruc, phone, address, email }),
    })
        .then(response => {
            if (response.ok) {
                Swal.fire({
                    title: isEditMode ? '¡Actualización exitosa!' : '¡Registro exitoso!',
                    text: isEditMode
                        ? 'El cliente fue actualizado correctamente.'
                        : 'El cliente fue registrado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                }).then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoCliente'));
                    modal.hide(); // Cierra el modal
                    cargarClientes(); // Recarga la tabla
                });
            } else {
                throw new Error(isEditMode ? 'No se pudo actualizar el cliente' : 'No se pudo registrar el cliente');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: '¡Error!',
                text: isEditMode
                    ? 'Hubo un problema al actualizar el cliente.'
                    : 'Hubo un problema al registrar el cliente.',
                icon: 'error',
                confirmButtonText: 'Intentar de nuevo',
            });
        });
});