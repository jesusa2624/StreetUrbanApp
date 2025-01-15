import { products, calculateTotals } from './table.js';

export function savePurchase() {
    const providerId = document.getElementById('provider_id').value;
    const tax = parseFloat(document.getElementById('tax').value);

    if (!providerId || products.length === 0) {
        Swal.fire('Error', 'Por favor complete todos los campos y agregue al menos un producto.', 'error');
        return;
    }

    const purchaseData = {
        provider_id: providerId,
        tax: tax,
        products: products.map(product => ({
            product_id: product.id,
            price: product.price,
            quantity: product.quantity,
        })),
    };

    console.log('Datos enviados al backend:', purchaseData);

    axios.post('/purchases', purchaseData)
        .then(response => {
            Swal.fire('Éxito', response.data.message, 'success');
        })
        .catch(error => {
            console.error('Error completo:', error.response?.data); // Muestra toda la respuesta en la consola
            const errorMessage = error.response?.data?.error || 'Ocurrió un error desconocido.';
            Swal.fire('Error', errorMessage, 'error'); // Muestra el mensaje detallado en SweetAlert
        });

}
