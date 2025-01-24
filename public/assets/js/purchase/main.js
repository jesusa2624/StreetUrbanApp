import { addProduct } from './products.js';
import { savePurchase } from './save.js';
import { initializeTable } from './table.js';
import { cargarCompras } from './listado.js';
import { cambiarEstadoCompra } from './status.js';


document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('submitForm').addEventListener('click', addProduct);
    document.getElementById('savePurchase').addEventListener('click', () => {
        savePurchase()
            .then(() => {
                cargarCompras(); // Recarga la tabla principal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoPurchase'));
                modal.hide(); // Cierra el modal
            })
            .catch(error => {
                console.error('Error al guardar la compra:', error);
            });
    });

    initializeTable(); // Inicializar la tabla del modal
    cargarCompras();    // Cargar las compras al iniciar
});
