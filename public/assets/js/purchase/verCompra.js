export function verCompra(purchaseId) {
    axios.get(`/purchases/${purchaseId}/details`)
        .then(response => {
            const purchase = response.data;

            let modalContent = `
                <div>
                    <h5>Detalles de la Compra</h5>
                    <p><strong>Proveedor:</strong> ${purchase.provider_name}</p>
                    <p><strong>Estado:</strong> ${purchase.status}</p>
                    <h6>Productos:</h6>
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Producto
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Precio (PEN)
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Cantidad
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Subtotal (PEN)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            purchase.products.forEach(product => {
                modalContent += `
                    <tr>
                        <td>${product.product_name}</td>
                        <td>${product.price}</td>
                        <td>${product.quantity}</td>
                        <td>${product.subtotal}</td>
                    </tr>
                `;
            });

            modalContent += `
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <td>PEN S/. ${(purchase.total / (1 + purchase.tax / 100)).toFixed(2)}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Impuesto (${purchase.tax}%):</th>
                                <td>PEN S/. ${(purchase.total - purchase.total / (1 + purchase.tax / 100)).toFixed(2)}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <td>PEN S/. ${purchase.total}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;

            Swal.fire({
                title: `Compra #${purchase.id}`,
                html: modalContent,
                icon: 'info',
                showCloseButton: true,
                width: '50%', // Tamaño XXL
                focusConfirm: false,
                confirmButtonText: 'Cerrar'
            });
        })
        .catch(error => {
            console.error('Error al obtener los detalles de la compra:', error);
            Swal.fire('Error', 'No se pudieron cargar los detalles de la compra.', 'error');
        });
}
