import { products, calculateTotals } from './table.js';

export function savePurchase() {
    return new Promise((resolve, reject) => {
        const providerId = document.getElementById('provider_id').value;
        const tax = parseFloat(document.getElementById('tax').value);

        if (!providerId || products.length === 0) {
            Swal.fire('Error', 'Por favor complete todos los campos y agregue al menos un producto.', 'error');
            reject(new Error('Datos incompletos o productos vacíos'));
            return;
        }

        const purchaseData = {
            provider_id: providerId,
            tax: tax,
            products: products.map(product => ({
                product_id: product.id,
                size_id: product.size.id, // Enviar solo el ID del tamaño
                price: product.price,
                quantity: product.quantity,
            })),
        };

        
        axios.post('/purchases', purchaseData)
            .then(response => {
                Swal.fire('Éxito', response.data.message, 'success').then(() => {
                    resolve(response);
                });
            })
            .catch(error => {
                console.error('Error completo:', error.response?.data);
                const errorMessage = error.response?.data?.error || 'Ocurrió un error desconocido.';
                Swal.fire('Error', errorMessage, 'error');
                reject(error);
            });
    });
}
