document.getElementById('modalNuevoProduct').addEventListener('show.bs.modal', function () {
    if (!isEditMode) {
        fetch('/products/next-barcode', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener el código de barras');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('code').value = data.nextCode; // Asigna el próximo código de barras
            })
            .catch(error => {
                console.error('Error al obtener el código de barras:', error);
                Swal.fire({
                    title: 'Error al cargar el código',
                    text: 'No se pudo obtener el próximo código de barras. Intente nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                });
            });
    }
});
