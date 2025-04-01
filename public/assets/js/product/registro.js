document.getElementById('submitForm').addEventListener('click', function () {
    const id = document.getElementById('idProduct').value;
    const name = document.getElementById('name').value;
    const code = document.getElementById('code').value;
    const sell_price = document.getElementById('sell_price').value;
    const category_id = document.getElementById('category_id').value;
    const provider_id = document.getElementById('provider_id').value;
    const image = document.getElementById('image').files[0]; // Obtener el archivo real
    const stock = 0;

    const url = isEditMode ? `/products/${id}` : '/products';
    const method = isEditMode ? 'PUT' : 'POST'; // Usar PUT para editar, POST para crear

    // Crear un FormData para manejar los datos
    const formData = new FormData();
    formData.append('name', name);
    formData.append('code', code);
    formData.append('sell_price', sell_price);
    formData.append('category_id', category_id);
    formData.append('provider_id', provider_id);
    formData.append('stock', stock);
    if (image) {
        formData.append('image', image);
    }

    // Agregar `_method` si es una actualización
    if (isEditMode) {
        formData.append('_method', 'PUT');
    }

    fetch(url, {
        method: 'POST', // Siempre usamos POST para Laravel con _method
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData,
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                title: isEditMode ? '¡Actualización exitosa!' : '¡Registro exitoso!',
                text: isEditMode
                    ? 'El producto fue actualizado correctamente.'
                    : 'El producto fue registrado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar',
            }).then(() => {
                const modalElement = document.getElementById('modalNuevoProduct');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);

                if (modalInstance) {
                    modalInstance.hide();
                    modalElement.addEventListener('hidden.bs.modal', function () {
                        cargarProducts(); // Asegura que la tabla se recargue después de cerrar el modal
                    }, { once: true });
                } else {
                    cargarProducts(); // Si el modal no está abierto, recarga directamente
                }
            });

        })

        .catch(error => {
            console.error('Error en la solicitud:', error);
            Swal.fire({
                title: '¡Error!',
                text: 'Hubo un problema al registrar/actualizar el producto.',
                icon: 'error',
                confirmButtonText: 'Intentar de nuevo',
            });
        });
});