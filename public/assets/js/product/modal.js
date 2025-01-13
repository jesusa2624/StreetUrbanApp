let isEditMode = false;

// Función para abrir el modal en modo "Crear"
function abrirModalCrear() {
    isEditMode = false;
    document.getElementById('modalNuevoProductLabel').innerText = 'Registro de Producto';
    document.getElementById('formNuevoProduct').reset();
    document.getElementById('idProduct').value = '';
    const modal = new bootstrap.Modal(document.getElementById('modalNuevoProducto'));
    modal.show();
}

// Función para abrir el modal en modo "Editar"
function abrirModalEditar(id) {
    isEditMode = true;
    document.getElementById('modalNuevoProductLabel').innerText = 'Editar Producto';

    fetch(`/products/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('idProduct').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('code').value = data.code;
            document.getElementById('sell_price').value = data.sell_price;
            document.getElementById('category_id').value = data.category_id;
            document.getElementById('provider_id').value = data.provider_id;
            document.getElementById('image').value = data.image;
            const modal = new bootstrap.Modal(document.getElementById('modalNuevoProduct'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al obtener los datos del producto:', error);
            alert('Hubo un problema al cargar los datos del producto.');
        });
}