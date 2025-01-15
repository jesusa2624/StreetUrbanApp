@extends('layouts.app')

@section('title', '- Compras')

@section('pages', 'Compras')

@section('content')

    <div class="container-fluid py-4">
        <div class="row my-4">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Compras</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalNuevoPurchase">
                                        + Nueva Compra
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalNuevoPurchase" tabindex="-1"
                                aria-labelledby="modalNuevoPurchaseLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content" style="background-color: #f7f7f7;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalNuevoPurchaseLabel">Registro de Compra
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formNuevoPurchase">
                                                <div class="row">
                                                    <div class="mb-3 col-6">
                                                        <label for="provider_id" class="form-label">Proveedor</label>
                                                        <select class="form-select" name="provider_id" id="provider_id">
                                                            <option value="">Cargando proveedor...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-6">
                                                        <label for="product_id" class="form-label">Producto</label>
                                                        <select class="form-select" name="product_id" id="product_id">
                                                            <option value="">Cargando producto...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-6">
                                                        <label for="tax" class="form-label">Impuesto</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"
                                                                    id="basic-addon3">%</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="tax"
                                                                id="tax" value="18"
                                                                aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-6">
                                                        <label for="quantity" class="form-label">Cantidad</label>
                                                        <input type="number" class="form-control" id="quantity"
                                                            name="quantity" placeholder="" required>
                                                    </div>
                                                    <div class="mb-3 col-6">
                                                        <label for="price" class="form-label">Precio de compra</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"
                                                                    id="basic-addon3">S/.</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="price"
                                                                id="price" aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="idPurchase">

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
                                                                                                    Precio(PEN)</th>
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
                                                                                                <th colspan="5">
                                                                                                </th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="5">
                                                                                                    <p class=" text-xxs font-weight-bolder"
                                                                                                        align="right">
                                                                                                        TOTAL: <span
                                                                                                            id="total">PEN
                                                                                                            0.00</span></p>
                                                                                                </th>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="5">
                                                                                                    <p class=" text-xxs font-weight-bolder"
                                                                                                        align="right">
                                                                                                        TOTAL IMPUESTO
                                                                                                        (18%): <span
                                                                                                            id="total_impuesto">PEN
                                                                                                            0.00</span></p>
                                                                                                </th>

                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="5">
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
                                            <button type="button" class="btn btn-primary"
                                                id="savePurchase">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
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
        const purchasesJsonUrl = "{{ route('purchases.json') }}";
    </script>


    <!-- Archivos de Módulo -->
    <script type="module" src="{{ asset('assets/js/purchase/table.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/purchase/save.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/purchase/products.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/purchase/main.js') }}"></script>

    <!-- Archivos No Módulo -->
    <script src="{{ asset('assets/js/purchase/select.js') }}"></script>
@endpush
