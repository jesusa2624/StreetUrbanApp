<div class="sidenav-header">
    <a class="navbar-brand m-0" href="#" target="_blank">
        <img src="{{ asset('assets/image/nav3.png') }}" class="navbar-brand-img" style="margin-top: -25px;" alt="main_logo">
    </a>
</div>
<hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->is('home*') ? 'bg-gradient-primary active' : '' }}"
                href="{{ url('/home') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-home" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Home</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-book" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Reportes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('purchases*') ? 'bg-gradient-primary active' : '' }}"
                href="{{ route('purchases.index') }}">

                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-store" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Compras</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-regular fa-money-bill-1" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Ventas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('products*') ? 'bg-gradient-primary active' : '' }}"
                href="{{ route('products.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-tags" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Productos</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('clients*') ? 'bg-gradient-primary active' : '' }}"
                href="{{ route('clients.index') }}">

                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-id-card" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Clientes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('categories*') ? 'bg-gradient-primary active' : '' }}"
                href="{{ route('categories.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-list" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Categorias</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('providers*') ? 'bg-gradient-primary active' : '' }}"
                href="{{ route('providers.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-truck" style="font-size: 18px;"></i>
                </div>
                <span class="nav-link-text ms-1">Proveedores</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-users" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Usuarios</span>
            </a>
        </li>

        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-key" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Roles</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-cog" style="font-size: 20px;"></i>
                </div>
                <span class="nav-link-text ms-1">Configuración</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-file-alt" style="font-size: 18px;"></i>
                </div>
                <span class="nav-link-text ms-1">Documentación</span>
            </a>
        </li>
    </ul>
</div>
<div class="sidenav-footer mx-3 ">
    <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
        <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpg')">
        </div>
        <div class="card-body text-start p-3 w-100">
            <div
                class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                <i class="ni ni-diamond text-dark text-gradient text-lg top-0" aria-hidden="true"
                    id="sidenavCardIcon"></i>
            </div>
            <div class="docs-info">
                <h6 class="text-white up mb-0">Need help?</h6>
                <p class="text-xs font-weight-bold">Please check our docs</p>
                <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/soft-ui-dashboard"
                    target="_blank" class="btn btn-white btn-sm w-100 mb-0">Documentation</a>
            </div>
        </div>
    </div>
    <a class="btn btn-primary mt-3 w-100"
        href="https://www.creative-tim.com/product/soft-ui-dashboard-pro?ref=sidebarfree">Upgrade to pro</a>
</div>
