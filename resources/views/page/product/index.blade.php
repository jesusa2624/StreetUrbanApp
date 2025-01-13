@extends('layouts.app')

@section('title', '- Productos')

@section('pages', 'Productos')

@section('content')

    <div class="container-fluid py-4">
        <div class="row my-4">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Productos</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalNuevoProducto">
                                        + Nuevo Producto
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalNuevoProducto" tabindex="-1"
                                aria-labelledby="modalNuevoProductoLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalNuevoProductoLabel">Registro de Cliente
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formNuevoCliente">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Nombre del producto" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="code" class="form-label">Código de Barras</label>
                                                    <input type="text" class="form-control" id="code" name="code" readonly placeholder="Generando código..." />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sell_price" class="form-label">Precio de Venta</label>
                                                    <input type="number" class="form-control" id="sell_price"
                                                        name="sell_price" placeholder="Precio de Venta" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="category_id" class="form-label">Categoria</label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        <option value="">Cargando categorias...</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="provider_id" class="form-label">Proveedor</label>
                                                    <select class="form-control" name="provider_id" id="provider_id">
                                                        <option value="">Cargando categorias...</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="picture" class="form-label">Imagen del Producto</label>
                                                    <input type="file" name="image" id="image" class="form-control"/>
                                                </div>
                                                <div class="mb-3">
                                                    <!-- Contenedor para la vista previa -->
                                                    <img id="preview" alt="Vista previa de la imagen" class="img-thumbnail" style="max-height: 200px; display: none;" />
                                                </div>
                                                <input type="hidden" id="idProduct">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="submitForm">Guardar</button>
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
                                            Stock
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Estado
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Categoria
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
        const productsJsonUrl = "{{ route('products.json') }}";
    </script>
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Obtiene el archivo seleccionado
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();

                // Carga la imagen y genera la vista previa
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Muestra la imagen
                };

                reader.readAsDataURL(file); // Lee el archivo seleccionado como DataURL
            } else {
                // Oculta la vista previa si no se selecciona un archivo
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    </script>



    <script src="{{ asset('assets/js/product/listado.js') }}"></script>
    <script src="{{ asset('assets/js/product/registro.js') }}"></script>
    <script src="{{ asset('assets/js/product/modal.js') }}"></script>
    <script src="{{ asset('assets/js/product/eliminar.js') }}"></script>
    <script src="{{ asset('assets/js/product/select.js') }}"></script>
    <script src="{{ asset('assets/js/product/codigo_barras.js') }}"></script>

@endpush
