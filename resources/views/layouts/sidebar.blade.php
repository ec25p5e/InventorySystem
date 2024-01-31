    @php
        $current_route=request()->route()->getName();
    @endphp

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="https://t3.ftcdn.net/jpg/04/45/05/86/360_F_445058628_VN7v6nniig1q5ojDwcGqcbu3IZPdR0Gc.jpg" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Gestione Magazzino</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <span href="#" class="d-block">{{ getUserById(Auth::id()) }}</span>
                    <p></p>
                    <span>{{ getPrimaryRoleForUnity(Auth::id()) }}</span>
                </div>
            </div>

            @if(checkPrimaryRole(Auth::id(), 'ADMIN') > 0)
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS')) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Prodotti
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_MOVEMENTS')) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Movimenti
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), 'ROLES')) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Gestione di sistema > Ruoli
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), 'ROUTE_CONF')) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Gestione di sistema > Configurazione dei percorsi
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            @elseif(checkPrimaryRole(Auth::id(), 'CUSTODE_SPAI') > 0 || checkPrimaryRole(Auth::id(), 'CUSTODE_SSMT') > 0)
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS')) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Prodotti
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_MOVEMENTS')) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Movimenti
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            @elseif(checkPrimaryRole(Auth::id(), 'SEG_SPAI') > 0 || checkPrimaryRole(Auth::id(), 'SEG_SSMT') > 0)
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS')) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Prodotti
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_MOVEMENTS')) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Movimenti
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </aside>

