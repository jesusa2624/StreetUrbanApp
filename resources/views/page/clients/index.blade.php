@extends('layouts.app')

@section('title', '- Clientes')

@section('pages', 'Clientes')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
@endpush

@section('content')

    <div class="container-fluid py-4">
        <div class="row my-4">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Clientes</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalNuevoCliente">
                                        + Nuevo Cliente
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalNuevoCliente" tabindex="-1"
                                aria-labelledby="modalNuevoClienteLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalNuevoClienteLabel">Registro de Cliente
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formNuevoCliente">
                                                <div>
                                                    <label for="dni" class="form-label">DNI</label>
                                                    <input type="number" class="form-control" id="dni" name="dni"
                                                        placeholder="DNI del cliente" required>
                                                    <button type="button" class="btn btn-info mt-1"
                                                        id="searchDni">Buscar</button>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Nombre del cliente" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ruc" class="form-label">RUC</label>
                                                    <input type="number" class="form-control" id="ruc" name="ruc"
                                                        placeholder="RUC del cliente" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Celular</label>
                                                    <input type="number" class="form-control" id="phone" name="phone"
                                                        placeholder="Número del cliente" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Dirección</label>
                                                    <input type="text" class="form-control" id="address" name="address"
                                                        placeholder="Dirección del cliente" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Correo electrónico</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="example@gmail.com" required>
                                                </div>
                                                <input type="hidden" id="idCliente">
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
                    <div class="card-body px-0 pb-2 m-4 p-3">
                        <div class="table-responsive">
                            <table id="clientesTabla" class="table align-items-center mb-0">
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
                                            DNI
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Celular
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Correo
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

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

    <script>
        const clientsJsonUrl = "{{ route('clients.json') }}";
    </script>


    <script src="{{ asset('assets/js/client/listado.js') }}"></script>
    <script src="{{ asset('assets/js/client/registro.js') }}"></script>
    <script src="{{ asset('assets/js/client/modal.js') }}"></script>
    <script src="{{ asset('assets/js/client/eliminar.js') }}"></script>
@endpush
