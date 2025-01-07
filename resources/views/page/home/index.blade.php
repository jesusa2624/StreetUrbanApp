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
                                        <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                            PEN S/ 1600
                                        </h5>
                                        <span class="text-white text-sm">Compras</span>
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
                                        <p class="text-white text-sm text-end font-weight-bolder mt-auto mb-0">Compras de
                                            Enero</p>
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
                                        <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                            PEN S/ 1600
                                        </h5>
                                        <span class="text-white text-sm">Ventas</span>
                                    </div>
                                    <div class="col-4">
                                        <div class="dropdown text-end mb-6">
                                            <a href="javascript:;" class="cursor-pointer" id="dropdownUsers1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h text-white"></i>
                                            </a>
                                            <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownUsers1">
                                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Ventas</a>
                                                </li>
                                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Registrar
                                                        una Venta</a></li>
                                            </ul>
                                        </div>
                                        <p class="text-white text-sm text-end font-weight-bolder mt-auto mb-0">Venta de
                                            Enero</p>
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
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID
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
                                    <t<tr>
                                    <td class="align-middle text-center text-sm">1</td>
                                    <td class="align-middle text-center text-sm">
                                        <img src="../assets/img/small-logos/logo-xd.svg"
                                            class="avatar avatar-sm me-4" alt="xd">
                                    </td>
                                    <td class="align-middle text-center text-sm">0001</td>
                                    <td class="align-middle text-center text-sm">10</td>
                                    <td class="align-middle text-center text-sm">15</td>
                                    <td class="align-middle text-center text-sm">
                                        <h6 class="mb-0 text-sm">Nick Force One</h6>
                                    </td>
                                   
                                    <td class="align-middle text-center text-sm">
                                            <button type="button" class="btn btn-primary">Ver</button>
                                    </td>
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
    <script>
        //Script para el grafico de compras
        const compra = document.getElementById('chart_compras').getContext('2d');

        const chart_compras = new Chart(compra, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
                datasets: [{
                    label: '',
                    data: [120, 190, 300, 500],
                    backgroundColor: [
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192,  0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                    ],
                    borderColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Esto elimina completamente la leyenda
                    }
                }
            }
        });
        //Script para el grafico de ventas
        const venta = document.getElementById('chart_ventas').getContext('2d');
        const chart_ventas = new Chart(venta, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
                datasets: [{
                    label: '',
                    data: [120, 190, 300, 500],
                    backgroundColor: [
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192,  0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                    ],
                    borderColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Esto elimina completamente la leyenda
                    }
                }
            }
        });
        //Chart de ventas diarias 
        const ctx = document.getElementById('chart_ventas_diarias').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(255, 120, 64, 0.8)');
        gradient.addColorStop(1, 'rgba(255, 206, 86, 0.8)');

        const chart_ventas_diarias = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Sales',
                    data: [120, 190, 300, 250, 320, 400],
                    backgroundColor: gradient, // Área debajo de la línea
                    borderColor: 'rgba(255, 159, 64, 1)', // Color de la línea
                    borderWidth: 2,
                    tension: 0.4, // Líneas curvas
                    pointBackgroundColor: 'rgba(255, 159, 64, 1)', // Color de los puntos
                    pointBorderColor: '#fff', // Borde blanco para los puntos
                    pointBorderWidth: 2,
                    pointRadius: 4, // Tamaño de los puntos
                    pointHoverRadius: 6, // Tamaño al pasar el cursor
                    fill: true // Rellena el área debajo de la línea
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false // Elimina líneas verticales del fondo
                        },
                        ticks: {
                            color: '#555' // Color de las etiquetas en el eje X
                        }
                    },
                    y: {
                        grid: {
                            drawBorder: false,
                            color: 'rgba(200, 200, 200, 0.3)' // Líneas de fondo
                        },
                        ticks: {
                            color: '#555', // Color de las etiquetas en el eje Y
                            stepSize: 50 // Incremento de los valores
                        }
                    }
                }
            },

        });
    </script>
@endpush
