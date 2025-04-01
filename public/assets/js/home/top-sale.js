document.addEventListener("DOMContentLoaded", function () {
    fetch("/products/top-selling")
        .then(response => response.json())
        .then(data => {
            console.log("Productos más vendidos:", data);

            const tableBody = document.querySelector(".table tbody");
            tableBody.innerHTML = ""; // Limpiar la tabla antes de agregar filas

            data.forEach((product, index) => {
                const row = `
                    <tr>
                        <td class="align-middle text-center text-sm">${index + 1}</td>
                        <td class="align-middle text-center text-sm">
                            <img src="${product.image}" class="avatar avatar-sm me-4" alt="${product.name}">
                        </td>
                        <td class="align-middle text-center text-sm">${product.name}</td>
                        <td class="align-middle text-center text-sm">${product.code}</td>
                        <td class="align-middle text-center text-sm">${product.stock}</td>
                        <td class="align-middle text-center text-sm">${product.total_sold}</td>
                        <td class="align-middle text-center text-sm">
                            <button type="button" class="btn btn-primary">Ver</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error al obtener productos más vendidos:", error));
});
