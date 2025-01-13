document.getElementById('modalNuevoProducto').addEventListener('show.bs.modal', function () {
    // Realiza una solicitud al servidor para obtener el siguiente código de barras
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
});

document.getElementById('submitForm').addEventListener('click', function () {
    const id = document.getElementById('idProduct').value;
    const name = document.getElementById('name').value;
    const code = document.getElementById('code').value;
    const sell_price = document.getElementById('sell_price').value;
    const category_id = document.getElementById('category_id').value;
    const provider_id = document.getElementById('provider_id').value;
    const image = document.getElementById('image').files[0]; // Obtener el archivo real
    const stock = 0;

    const url = id ? `/products/${id}` : '/products'; // Si hay un ID, es edición, sino es creación
    const method = id ? 'POST' : 'POST'; // Cambiar PUT por POST si no se está utilizando `_method` en Laravel.

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

    fetch(url, {
        method: method,
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
            console.log('Producto registrado:', data);
            Swal.fire({
                title: '¡Registro exitoso!',
                text: 'El producto fue registrado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar',
            }).then(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoProducto'));
                modal.hide();
                cargarProducts(); // Recarga la tabla de productos
            });
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            Swal.fire({
                title: '¡Error!',
                text: 'Hubo un problema al registrar el producto.',
                icon: 'error',
                confirmButtonText: 'Intentar de nuevo',
            });
        });
});

