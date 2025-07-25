<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        <li class="nav-item">
            <a class="nav-link" href="/dashboard">
                <i class="ti-trello menu-icon"></i>
                <span class="menu-title">Panel</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-admin" aria-expanded="false" aria-controls="ui-admin">
                <i class="ti-settings menu-icon"></i>
                <span class="menu-title">Administración</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-admin">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.servicios.index') }}">
                            <span class="menu-title">Servicios</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sucursales.index') }}">
                            <span class="menu-title">Sucursales</span>
                        </a>
                    </li>

                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-fichas" aria-expanded="false"
                aria-controls="ui-fichas">
                <i class="ti-settings menu-icon"></i>
                <span class="menu-title">Fichas</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-fichas">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ficha.solicitar') }}">
                            <span class="menu-title">Ficha CI</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ficha.mostrar') }}">
                            <span class="menu-title">Ver mi ficha</span>
                        </a>
                    </li>
                    
                </ul>
            </div>
        </li>



        <li class="nav-item">
            <a class="nav-link" href="/verificar">
                <i class="ti-trello menu-icon"></i>
                <span class="menu-title">Solicitar Ficha</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/documento/formulario">
                <i class="ti-trello menu-icon"></i>
                <span class="menu-title">Documento Judicial</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/brigada/solicitar">
                <i class="ti-trello menu-icon"></i>
                <span class="menu-title">Solicitar Brigada</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/solicitud_brigada">
                <i class="ti-trello menu-icon"></i>
                <span class="menu-title">Ver Solicitudes Brigada</span>
            </a>
        </li>

    </ul>
</nav>

<!-- use los iconos de la pagina https://themify.me/themify-icons -->
