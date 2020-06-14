<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Soluciones</span>
        <img src="{{ asset('img/icono.png') }}" alt="Soluciones" width="40" class=""
            style="opacity: .8">
        <span class="brand-text font-weight-light">Ecológocas</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if($usuario['img']=="" || $usuario['img']==null)         
                    <img src="{{ asset('img/usuarios/default.png') }}" class="img-circle elevation-2 bg-white" alt="">
                @else
                    <img src="{{ $usuario['img'] }}" class="img-circle elevation-2" alt="">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ $usuario['nombre'] }} {{ $usuario['apellido'] }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Factura -->
                <li class="nav-item has-treeview <?php if($idMenu==1) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if($idMenu==1) echo 'active'; ?>">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Factura<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('FacturaController@index') }}" class="nav-link <?php if($idMenu==1 && $idSubMenu==1) echo 'active'; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Crear</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('FacturaController@listaFinalizadas') }}" class="nav-link <?php if($idMenu==1 && $idSubMenu==2) echo 'active'; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Realizadas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('FacturaController@listaAvances') }}" class="nav-link <?php if($idMenu==1 && $idSubMenu==3) echo 'active'; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Avance</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Guia de remision -->
                <li class="nav-item">
                    <a href="{{ action('GuiaRemisionController@index') }}" class="nav-link <?php if($idMenu==2) echo 'active'; ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Guía de remisión<span class="right badge badge-danger">New</span></p>
                    </a>
                </li>

                <!-- productos -->
                <li class="nav-item">
                    <a href="{{ route('productos') }}" class="nav-link <?php if($idMenu==3) echo 'active'; ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Productos</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
    