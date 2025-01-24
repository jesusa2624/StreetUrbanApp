document.addEventListener('DOMContentLoaded', () => {
    const saveButton = document.getElementById('saveSale');

    function validateStock() {
        // Verifica si hay algún producto con stock inválido
        const hasInvalidStock = products.some(product => {
            const stock = parseInt(document.querySelector(`#product_id option[value="${product.id}"]`).dataset.stock);
            return stock === 0 || product.quantity > stock;
        });

        // Habilita o deshabilita el botón según el estado del stock
        saveButton.disabled = hasInvalidStock;
    }

    // Revalida stock en cada acción
    document.getElementById('product_id').addEventListener('change', validateStock);
    document.getElementById('quantity').addEventListener('input', validateStock);
    document.getElementById('submitForm').addEventListener('click', validateStock);
});
