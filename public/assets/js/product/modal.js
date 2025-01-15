let isEditMode = false;

// Función para abrir el modal en modo "Crear"
function abrirModalCrear() {
    isEditMode = false;
    document.getElementById('modalNuevoProductLabel').innerText = 'Registro de Producto';
    document.getElementById('formNuevoProduct').reset();
    document.getElementById('idProduct').value = '';
    const modal = new bootstrap.Modal(document.getElementById('modalNuevoProduct'));
    modal.show();
}
// Función para abrir el modal en modo "Editar"
function abrirModalEditar(id) {
    isEditMode = true; // Cambia a modo edición
    document.getElementById('modalNuevoProductLabel').innerText = 'Editar Producto';

    fetch(`/products/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Asigna los valores del producto al formulario
            document.getElementById('idProduct').value = data.id || '';
            document.getElementById('name').value = data.name || '';
            document.getElementById('code').value = data.code || '';
            document.getElementById('sell_price').value = data.sell_price || '';
            document.getElementById('category_id').value = data.category_id || '';
            document.getElementById('provider_id').value = data.provider_id || '';

            // Mostrar vista previa de la imagen
            const preview = document.getElementById('preview'); // Elemento <img> en el modal
            if (data.image) {
                preview.src = `/${data.image}`; // Asegúrate de que la URL sea correcta
                preview.style.display = 'block'; // Muestra la imagen
            } else {
                preview.src = '';
                preview.style.display = 'none'; // Oculta si no hay imagen
            }

            const modalElement = document.getElementById('modalNuevoProduct');
            if (modalElement) {
                const modalInstance = new bootstrap.Modal(modalElement); // Crea una nueva instancia del modal
                modalInstance.show(); // Abre el modal
            } else {
                console.error('El modal con ID modalNuevoProduct no existe en el DOM.');
            }
        })
        .catch(error => {
            console.error('Error al obtener los datos del producto:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al cargar los datos del producto.',
                icon: 'error',
                confirmButtonText: 'Aceptar',
            });
        });
}


