// Manejo del botón "Guardar" en el modal
document.getElementById('submitForm').addEventListener('click', function () {
    const id = document.getElementById('idCategoria').value;
    const name = document.getElementById('nombreCategoria').value;
    const description = document.getElementById('descripcionCategoria').value;

    const url = isEditMode ? `/categories/${id}` : '/categories';
    const method = isEditMode ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ name, description }),
    })
        .then(response => {
            if (response.ok) {
                Swal.fire({
                    title: isEditMode ? '¡Actualización exitosa!' : '¡Registro exitoso!',
                    text: isEditMode
                        ? 'La categoría fue actualizada correctamente.'
                        : 'La categoría fue registrada correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                }).then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevaCategoria'));
                    modal.hide(); // Cierra el modal
                    cargarCategorias(); // Recarga la tabla
                });
            } else {
                throw new Error(isEditMode ? 'No se pudo actualizar la categoría' : 'No se pudo registrar la categoría');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: '¡Error!',
                text: isEditMode
                    ? 'Hubo un problema al actualizar la categoría.'
                    : 'Hubo un problema al registrar la categoría.',
                icon: 'error',
                confirmButtonText: 'Intentar de nuevo',
            });
        });
});
