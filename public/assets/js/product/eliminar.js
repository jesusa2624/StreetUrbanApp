function borrarProducto(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminarlo',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire(
                        'Eliminado!',
                        'El producto ha sido eliminado.',
                        'success'
                    ).then(() => {
                        cargarProducts(); 
                    });
                } else {
                    throw new Error('No se pudo eliminar el producto');
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error',
                    'Hubo un problema al eliminar el producto.',
                    'error'
                );
            });
        }

    })
}
