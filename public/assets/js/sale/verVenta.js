export function verVenta(saleId) {
    axios.get(`/sales/${saleId}/details`)
        .then(response => {
            const sale = response.data;

            let modalContent = `
                <div>
                    <h5>Detalles de la Venta</h5>
                    <p><strong>Cliente:</strong> ${sale.client_name}</p>
                    <p><strong>Estado:</strong> ${sale.status}</p>
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

            sale.products.forEach(product => {
                modalContent += `
                    <tr>
                        <td class="text-center">${product.product_name}</td>
                        <td class="text-center">${product.price.toFixed(2)}</td>
                        <td class="text-center">${product.quantity}</td>
                        <td class="text-center">${(product.quantity * product.price).toFixed(2)}</td>
                    </tr>
                `;
            });

            modalContent += `
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <td>PEN S/. ${(sale.total / (1 + sale.tax / 100)).toFixed(2)}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Impuesto (${sale.tax}%):</th>
                                <td>PEN S/. ${(sale.total - sale.total / (1 + sale.tax / 100)).toFixed(2)}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <td>PEN S/. ${sale.total.toFixed(2)}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;

            Swal.fire({
                title: `Venta #${sale.id}`,
                html: modalContent,
                icon: 'info',
                showCloseButton: true,
                width: '50%', // Tamaño del modal
                focusConfirm: false,
                confirmButtonText: 'Cerrar'
            });
        })
        .catch(error => {
            console.error('Error al obtener los detalles de la venta:', error);
            Swal.fire('Error', 'No se pudieron cargar los detalles de la venta.', 'error');
        });
}
