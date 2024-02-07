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

            @foreach(getSidebarMenu(Auth::id()) as $menu)
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column @if($current_route == $menu->route_name) active @endif" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route(getRoute(Auth::id(), $menu->route_code)) }}" class="nav-link">
                                <p>
                                    {{ $menu->route_text }}
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endforeach
        </div>
    </aside>

