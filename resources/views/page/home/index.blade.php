@extends('layouts.app')

@section('title', '- Home')

@section('pages', 'Home')


@section('content')

    <div class="container-fluid py-4">

        <div class="row card shadow">
            <div class="col-lg-12 col-12 card-header ">
                <div class="row">

                    <div class="col-lg-6 col-md-6 col-12 mt-3">
                        <div class="card">
                            <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                            <div class="card-body p-3 position-relative">
                                <div class="row">
                                    <div class="col-8 text-start">
                                        <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                            <i class="fas fa-shopping-cart" style="font-size: 24px; color:black"></i>
                                        </div>
                                        <h5 class="text-white font-weight-bolder mb-0 mt-3 compras-total">
                                            PEN S/ 0
                                        </h5>
                                        <span class="text-white text-sm compras-texto">Compras</span>


                                    </div>
                                    <div class="col-4">
                                        <div class="dropdown text-end mb-6">
                                            <a href="javascript:;" class="cursor-pointer" id="dropdownUsers1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h text-white"></i>
                                            </a>
                                            <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownUsers1">
                                                <li><a class="dropdown-item border-radius-md"
                                                        href="javascript:;">Compras</a></li>
                                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Registrar
                                                        una Compra</a></li>
                                            </ul>
                                        </div>
                                        <p class="text-white text-sm text-end font-weight-bolder mt-auto mb-0 compras-mes">
                                            Compras de Enero
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12 mt-3 mb-4">
                        <div class="card">
                            <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                            <div class="card-body p-3 position-relative">
                                <div class="row">
                                    <div class="col-8 text-start">
                                        <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                            <i class="fas fa-shopping-bag" style="font-size: 24px; color:black"></i>
                                        </div>
                                        <h5 class="text-white font-weight-bolder mb-0 mt-3 ventas-total">
                                            PEN S/ 0.00
                                        </h5>
                                        <span class="text-white text-sm ventas-cantidad">Ventas</span>
                                    </div>
                                    <div class="col-4">
                                        <div class="dropdown text-end mb-6">
                                            <a href="javascript:;" class="cursor-pointer" id="dropdownUsers2"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h text-white"></i>
                                            </a>
                                            <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownUsers2">
                                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Ventas</a>
                                                </li>
                                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Registrar
                                                        una Venta</a></li>
                                            </ul>
                                        </div>
                                        <p class="text-white text-sm text-end font-weight-bolder mt-auto mb-0 ventas-mes">
                                            Ventas de Enero
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="row ">

            <div class="col-lg-6 col-md-6 col-12 mt-3">
                <div class="card z-index-2">
                    <div class="card-header pb-0">
                        <h6>Compras por Mes</h6>
                        <p class="text-sm">

                            <span class="font-weight-bold">Mes de: </span> Enero 2025
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart_compras" class="chart-canvas" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-12 mt-3">
                <div class="card z-index-2">
                    <div class="card-header pb-0">
                        <h6>Ventas por Mes</h6>
                        <p class="text-sm">
                            <span class="font-weight-bold">Mes de: </span> Enero 2025
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart_ventas" class="chart-canvas" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row my-4">
            <div class="col-lg-12">
                <div class="card z-index-2">
                    <div class="card-header pb-0">
                        <h6>Ventas diarias</h6>
                        <p class="text-sm">

                            <span class="font-weight-bold">Mes de: </span> Enero 2025
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart_ventas_diarias" class="chart-canvas" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Productos más Vendidos</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-secondary"></i>
                                    </a>
                                    <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">Another
                                                action</a></li>
                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else
                                                here</a></li>
                                    </ul>
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
                                            Nº
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Imagen</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Codigo</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Stock</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Cantidad vendida</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Opciones</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                          
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <footer class="footer pt-3  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                Tim</a>
                            for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                    target="_blank">Creative
                                    Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                    target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                    target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                    target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    {{-- Scripts dinamicos de los graficos --}}
    <script src="{{ asset('assets/js/home/purchase-month.js') }}"></script>
    <script src="{{ asset('assets/js/home/sales-month.js') }}"></script>
    <script src="{{ asset('assets/js/home/sales-daily.js') }}"></script>
    <script src="{{ asset('assets/js/home/top-sale.js') }}"></script>




    <script></script>
@endpush
