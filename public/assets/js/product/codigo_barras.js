let currentBarcode = '00000001'; // Código inicial predeterminado

// Función que asigna el código de barras al abrir el modal
document.getElementById('modalNuevoProducto').addEventListener('show.bs.modal', function() {
    const codeInput = document.getElementById('code');
    codeInput.value = currentBarcode; // Asigna el próximo código automáticamente
});

// Función para manejar el registro del producto
document.getElementById('submitForm').addEventListener('click', function() {
    const codeInput = document.getElementById('code').value;

    // Simulación del registro del producto
    console.log('Producto registrado con código:', codeInput);

    // Incrementa el código de barras automáticamente
    currentBarcode = incrementBarcode(currentBarcode);

    // Cierra el modal automáticamente (si usas Bootstrap)
    const modalElement = document.getElementById('modalNuevoProducto');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    modalInstance.hide();
});

// Función para incrementar el código de barras
function incrementBarcode(barcode) {
    const number = parseInt(barcode, 10); // Convierte el código a número
    const incremented = number + 1; // Incrementa el número
    return incremented.toString().padStart(8, '0'); // Asegura 8 dígitos con ceros a la izquierda
}
