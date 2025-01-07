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
                                    <!-- Botón que activa el modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalNuevaCategoria">
                                        + Nueva Categoria
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalNuevaCategoria" tabindex="-1"
                                aria-labelledby="modalNuevaCategoriaLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Header del Modal -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalNuevaCategoriaLabel">Registro de Categorias
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <!-- Cuerpo del Modal -->
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
                                            </form>
                                        </div>
                                        <!-- Footer del Modal -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary"
                                                id="submitForm">Registrar</button>
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
                                    <tr>
                                        <td class="align-middle text-center text-sm">1</td>
                                        <td class="align-middle text-center text-sm">
                                            <h6 class="mb-0 text-sm">Zapatillas Futsal</h6>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <h6 class="mb-0 text-sm">Nick Force One</h6>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <button type="button" class="btn btn-secondary">Editar</button>
                                            <button type="button" class="btn btn-danger">Borrar</button>

                                        </td>
                                    </tr>
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
    <script>
        document.getElementById('submitForm').addEventListener('click', function() {
            // Obtener los datos del formulario
            const name = document.getElementById('nombreCategoria').value;
            const description = document.getElementById('descripcionCategoria').value;

            // Crear el objeto con los datos
            const data = {
                name: name,
                description: description,
            };

            // Enviar la solicitud al servidor
            axios.post("{{ route('categories.store') }}", data, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    alert('Categoría registrada exitosamente');
                    console.log(response.data);
                    document.getElementById('formNuevaCategoria').reset();
                })
                .catch(error => {
                    console.error('Error:', error.response.data);
                    alert('Hubo un error al registrar la categoría.');
                });
        });
    </script>
@endpush
