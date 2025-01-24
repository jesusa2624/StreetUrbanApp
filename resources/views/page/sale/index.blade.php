@extends('layouts.app')

@section('title', '- Ventas')

@section('pages', 'Ventas')

@section('content')

    <div class="container-fluid py-4">
        <div class="row my-4">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Ventas</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalNuevoSale">
                                        + Nueva Compra
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalNuevoSale" tabindex="-1"
                                aria-labelledby="modalNuevoSaleLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content" style="background-color: #f7f7f7;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalNuevoSaleLabel">Registro de Venta
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formNuevoSale">
                                                <div class="row">
                                                    <div class="mb-3 col-6">
                                                        <label for="client_id" class="form-label">Cliente</label>
                                                        <select class="form-select" name="client_id" id="client_id">
                                                            <option value="">Cargando cliente...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-6">
                                                        <label for="product_id" class="form-label">Producto</label>
                                                        <select class="form-select" name="product_id" id="product_id">
                                                            <option value="">Cargando producto...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="code" class="form-label">Codigo de barras</label>
                                                        <input type="number" class="form-control" id="code"
                                                            name="code" placeholder="" required>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="tax" class="form-label">Impuesto</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"
                                                                    id="basic-addon3">%</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="tax"
                                                                id="tax" value="0"
                                                                aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="stock" class="form-label">Stock actual</label>
                                                        <input type="number" class="form-control" id="stock"
                                                            name="stock" placeholder="" required>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="quantity" class="form-label">Cantidad</label>
                                                        <input type="number" class="form-control" id="quantity"
                                                            name="quantity" placeholder="" required>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="price" class="form-label">Precio de venta</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"
                                                                    id="basic-addon3">S/.</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="price"
                                                                id="price" aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="discount" class="form-label">Porcentaje de descuento</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"
                                                                    id="basic-addon3">%</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="discount"
                                                                id="discount" value="0"
                                                                aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="idSale">

                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-warning w-50"
                                                            id="submitForm">Agregar Producto</button>
                                                    </div>

                                                    <div class="container-fluid py-4">
                                                        <div class="row my-4">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-header pb-0">
                                                                        <div class="row">
                                                                            <div class="card-body">
                                                                                <div class="table-responsive">
                                                                                    <table
                                                                                        class="table align-items-center mb-0">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th
                                                                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                    Eliminar</th>
                                                                                                <th
                                                                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                    Producto</th>
                                                                                                <th
                                                                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                    Precio (PEN)</th>
                                                                                                <th
                                                                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                    Descuento</th>
                                                                                                <th
                                                                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                    Cantidad</th>
                                                                                                <th
                                                                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                    Subtotal(PEN)</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <!-- Los datos serán cargados dinámicamente -->
                                                                                        </tbody>
                                                                                        <tfoot>
                                                                                            <tr>
                                                                                                <th colspan="6">
                                                                                                </th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="6">
                                                                                                    <p class=" text-xxs font-weight-bolder"
                                                                                                        align="right">
                                                                                                        TOTAL: <span
                                                                                                            id="total">PEN
                                                                                                            0.00</span></p>
                                                                                                </th>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="6">
                                                                                                    <p class=" text-xxs font-weight-bolder"
                                                                                                        align="right">
                                                                                                        TOTAL IMPUESTO
                                                                                                        (18%): <span
                                                                                                            id="total_impuesto">PEN
                                                                                                            0.00</span></p>
                                                                                                </th>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="6">
                                                                                                    <p class=" text-xxs font-weight-bolder"
                                                                                                        align="right">
                                                                                                        TOTAL PAGAR: <span
                                                                                                            align="right"
                                                                                                            id="total_pagar_html">PEN
                                                                                                            0.00</span></p>
                                                                                                </th>
                                                                                            </tr>
                                                                                        </tfoot>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-primary" id="saveSale">Guardar</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive-principal">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Estado
                                        </th>
                                        
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Opciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Los datos serán cargados dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const salesJsonUrl = "{{ route('sales.json') }}";
    </script>


    <!-- Archivos de Módulo -->
    <script type="module" src="{{ asset('assets/js/sale/table.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/sale/save.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/sale/products.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/sale/main.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/sale/listado.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/sale/verVenta.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/sale/status.js') }}"></script>


    {{-- <script type="module" src="{{ asset('assets/js/purchase/eliminar.js') }}"></script> --}}



    
    <!-- Archivos No Módulo -->
    <script src="{{ asset('assets/js/sale/select.js') }}"></script>
@endpush
