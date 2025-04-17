document.getElementById('submitForm').addEventListener('click', function () {
    const id = document.getElementById('idProvider').value;
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const ruc = document.getElementById('ruc').value;
    const address = document.getElementById('address').value;
    const phone = document.getElementById('phone').value;

    const url = isEditMode ? `/providers/${id}` : '/providers';
    const method = isEditMode ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ name, email, ruc, address, phone }),
    })
        .then(response => {
            if (response.ok) {
                Swal.fire({
                    title: isEditMode ? '¡Actualización exitosa!' : '¡Registro exitoso!',
                    text: isEditMode
                        ? 'El proveedor fue actualizado correctamente.'
                        : 'El proveedor fue registrado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                }).then(() => {
                    // Cerrar el modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoProvider'));
                    modal.hide(); // Cierra el modal
                    cargarProviders(); // Recarga la tabla
                });
            } else {
                throw new Error(isEditMode ? 'No se pudo actualizar el proveedor' : 'No se pudo registrar el proveedor');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: '¡Error!',
                text: isEditMode
                    ? 'Hubo un problema al actualizar el proveedor.'
                    : 'Hubo un problema al registrar el proveedor.',
                icon: 'error',
                confirmButtonText: 'Intentar de nuevo',
            });
        });
});

// Agregar el evento de cerrar al botón de cancelar
document.getElementById('cancelButton').addEventListener('click', function () {
    // Cerrar el modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoProvider'));
    modal.hide();
});
