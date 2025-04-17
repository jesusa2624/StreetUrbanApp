@extends('layouts.app')

@section('title', '- Categorias')

@section('pages', 'Categorias')

@section('content')

    <div class="container-fluid py-4">
        <div class="row my-4">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Categorias</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalNuevaCategoria">
                                        + Nueva Categoria
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalNuevaCategoria" tabindex="-1"
                                aria-labelledby="modalNuevaCategoriaLabel" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalNuevaCategoriaLabel">Registro de Categorías
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formNuevaCategoria">
                                                <div class="mb-3">
                                                    <label for="nombreCategoria" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombreCategoria"
                                                        name="nombre" placeholder="Nombre de la categoría" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcionCategoria" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcionCategoria" name="descripcion" rows="3"
                                                        placeholder="Descripción de la categoría"></textarea>
                                                </div>
                                                <input type="hidden" id="idCategoria">
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
                                            Descripción
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

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const categoriesJsonUrl = "{{ route('categories.json') }}";
    </script>
    

    <script src="{{ asset('assets/js/category/listado.js') }}"></script>
    <script src="{{ asset('assets/js/category/registro.js') }}"></script>
    <script src="{{ asset('assets/js/category/modal.js') }}"></script>
    <script src="{{ asset('assets/js/category/eliminar.js') }}"></script>
@endpush
