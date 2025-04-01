import { cambiarEstadoCompra } from './status.js';
import { verCompra } from './verCompra.js';


export function cargarCompras() {
    const table = $("#purchasesTable").DataTable({
        destroy: true, // Evita errores al reinicializar
        processing: true,
        order: [[0, "desc"]], // Ordenar por ID en forma descendente
        ajax: function (data, callback) {
            axios.get('/purchases/getPurchases')
                .then(response => {
                    callback({ data: response.data });
                })
                .catch(error => {
                    console.error('Error al cargar compras:', error);
                    Swal.fire('Error', 'No se pudieron cargar las compras.', 'error');
                    callback({ data: [] });
                });
        },
        columns: [
            { data: "id", className: "text-center text-xxs font-weight-bolder"},
            { data: "purchase_date", className: "text-center text-xxs font-weight-bolder" },
            { 
                data: "products",
                className: "text-center text-xxs font-weight-bolder",
                render: data => data.map(p => `${p.product_name} (${p.quantity})`).join(", ")
            },
            { 
                data: "products",
                className: "text-center text-xxs font-weight-bolder",
                render: data => data.map(p => p.size ? p.size : 'Sin talla').join(", ")
            },
            { 
                data: "status",
                className: "text-center text-xxs font-weight-bolder",
                render: (data, _, row) => {
                    let btnClass = data === 'VALID' ? 'btn-success' : 'btn-danger';
                    let icon = data === 'VALID' ? 'fa-check' : 'fa-times';
                    return `<button class="btn ${btnClass} estado-btn" data-id="${row.id}">
                                ${data === 'VALID' ? 'Activo' : 'Cancelado'}
                                <i class="fas ${icon}"></i>
                            </button>`;
                }
            },
            { 
                data: "total",
                className: "text-center text-xxs font-weight-bolder",
                render: data => `PEN ${data}`
            },
            { 
                data: "id",
                className: "text-center text-xxs font-weight-bolder",
                render: data => `<button class="btn btn-warning ver-btn" data-id="${data}">
                                    <i class="fa-solid fa-file-invoice fa-2x"></i>
                                </button>`
            }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        },
        responsive: true,
        lengthMenu: [5, 10, 25, 50],
        pageLength: 10
    });

    // Delegación de eventos para botones
    $("#purchasesTable tbody").on("click", ".estado-btn", function () {
        let id = $(this).data("id");
        cambiarEstadoCompra(id);
    });

    $("#purchasesTable tbody").on("click", ".ver-btn", function () {
        let id = $(this).data("id");
        verCompra(id);
    });
}
