document.addEventListener('DOMContentLoaded', () => {
    const categorySelect = document.getElementById('category_id');
    const providerSelect = document.getElementById('provider_id');

    // Función para cargar categorías
    const cargarCategorias = async () => {
        try {
            const response = await fetch('/categories/getCategories');
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const categories = await response.json();

            // Limpia el select antes de llenarlo
            categorySelect.innerHTML = '<option value="">Seleccione una categoría</option>';

            // Recorre los datos y añade las opciones al select
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar las categorías:', error);
            categorySelect.innerHTML = '<option value="">Error al cargar categorías</option>';
        }
    };

    // Función para cargar proveedores
    const cargarProveedores = async () => {
        try {
            const response = await fetch('/providers/getProviders');
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const providers = await response.json();

            // Limpia el select antes de llenarlo
            providerSelect.innerHTML = '<option value="">Seleccione un proveedor</option>';

            // Recorre los datos y añade las opciones al select
            providers.forEach(provider => {
                const option = document.createElement('option');
                option.value = provider.id;
                option.textContent = provider.name;
                providerSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar los proveedores:', error);
            providerSelect.innerHTML = '<option value="">Error al cargar proveedores</option>';
        }
    };

    // Llama a ambas funciones al cargar el DOM
    cargarCategorias();
    cargarProveedores();
});
