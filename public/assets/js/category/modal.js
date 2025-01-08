let isEditMode = false;

// Función para abrir el modal en modo "Crear"
function abrirModalCrear() {
    isEditMode = false;
    document.getElementById('modalNuevaCategoriaLabel').innerText = 'Registro de Categorías';
    document.getElementById('formNuevaCategoria').reset();
    document.getElementById('idCategoria').value = '';
    const modal = new bootstrap.Modal(document.getElementById('modalNuevaCategoria'));
    modal.show();
}

// Función para abrir el modal en modo "Editar"
function abrirModalEditar(id) {
    isEditMode = true;
    document.getElementById('modalNuevaCategoriaLabel').innerText = 'Editar Categoría';

    fetch(`/categories/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('idCategoria').value = data.id;
            document.getElementById('nombreCategoria').value = data.name;
            document.getElementById('descripcionCategoria').value = data.description;
            const modal = new bootstrap.Modal(document.getElementById('modalNuevaCategoria'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al obtener los datos de la categoría:', error);
            alert('Hubo un problema al cargar los datos de la categoría.');
        });
}
