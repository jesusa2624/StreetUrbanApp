import { products } from './table.js';

export function saveSale() {
    return new Promise((resolve, reject) => {
        const clientId = document.getElementById('client_id').value;
        const tax = parseFloat(document.getElementById('tax').value);

        if (!clientId || products.length === 0) {
            Swal.fire('Error', 'Por favor complete todos los campos y agregue al menos un producto.', 'error');
            reject(new Error('Datos incompletos o productos vacíos'));
            return;
        }

        const saleData = {
            client_id: clientId,
            tax: tax,
            products: products.map(product => ({
                product_id: product.id,
                price: product.price,
                quantity: product.quantity,
                discount: product.discount,
            })),
        };

        axios.post('/sales', saleData)
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
