import { addProduct } from './products.js';
import { initializeTable } from './table.js';
import { saveSale } from './save.js';
import { cargarVentas } from './listado.js';

document.addEventListener('DOMContentLoaded', () => {
    // Configuración de botones
    document.getElementById('submitForm').addEventListener('click', addProduct);

    document.getElementById('saveSale').addEventListener('click', () => {
        saveSale()
            .then(() => {
                cargarVentas(); // Recarga la tabla principal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoSale'));
                modal.hide(); // Cierra el modal
            })
            .catch(error => {
                console.error('Error al guardar la venta:', error);
            });
    });

    // Inicializar la tabla del modal
    initializeTable();

    // Cargar las ventas al iniciar
    cargarVentas();
});
