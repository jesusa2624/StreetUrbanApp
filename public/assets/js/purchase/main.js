import { addProduct } from './products.js';
import { savePurchase } from './save.js';
import { initializeTable } from './table.js';

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('submitForm').addEventListener('click', addProduct);
    document.getElementById('savePurchase').addEventListener('click', savePurchase);

    initializeTable(); // Inicializar la tabla
});
