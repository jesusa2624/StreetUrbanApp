// Define cargarCategorias como una función global
window.cargarCategorias = async function () {
    try {
        const url = categoriesJsonUrl; // Usa la variable global generada en Blade
        const response = await fetch(url); // Realiza la solicitud GET al backend
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const categories = await response.json(); // Convierte la respuesta a JSON

        const tbody = document.querySelector('tbody'); // Selecciona el <tbody>
        if (!tbody) throw new Error('No se encontró el elemento <tbody> en el DOM.');

        tbody.innerHTML = ''; // Limpia el contenido del <tbody>

        // Itera sobre las categorías y las agrega a la tabla
        categories.forEach((category) => {
            tbody.innerHTML += `
                <tr>
                    <td class="align-middle text-center text-sm">${category.id}</td>
                    <td class="align-middle text-center text-sm">${category.name}</td>
                    <td class="align-middle text-center text-sm">${category.description}</td>
                    <td class="align-middle text-center text-sm">
                        <button type="button" class="btn btn-secondary" onclick="abrirModalEditar(${category.id})">Editar</button>
                        <button type="button" class="btn btn-danger" onclick="borrarCategoria(${category.id})">Borrar</button>
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        alert('Hubo un error al cargar las categorías. Por favor, intenta nuevamente.');
    }
};

// Ejecuta cargarCategorias cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    cargarCategorias();
});
