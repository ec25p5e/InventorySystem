@php
    $current_route = request()->route()->getName();
@endphp


<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html">
            <img src="{{ asset('assets/images/images.jpg') }}" style="width: 60px" alt="" class="dark-logo" />
            <img
                src="{{ asset('assets/images/images.jpg') }}" style="width: 60px"
                alt=""
                class="light-logo"
            />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                @foreach(getSidebarMenu(Auth::id()) as $menu)
                    @if($menu->route_parent_id == null)
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle"><span class="micon bi bi-house"></span><span class="mtext">{{ $menu->route_text }}</span></a>

                            @if($menu->children->isNotEmpty())
                                <ul class="submenu">
                                    @foreach ($menu->children as $child)
                                        <li>
                                            <a href="{{ route($child->route_name) }}">{{ $child->route_text }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach

                <li>
                    <div class="dropdown-divider"></div>
                </li>

                @if(hasRole(Auth::id(), 'ADMIN') == 0)
                    <li>
                        <a href="javascript:;" class="dropdown-toggle"><span class="mtext">Serve aiuto?</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="">Introduction</a></li>
                            <li><a href="">Getting Started</a></li>
                            <li><a href="">Color Settings</a></li>
                            <li><a href="">Third Party Plugins</a></li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="javascript:;" class="dropdown-toggle"><span class="mtext">Documentazione tecnica</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('docs') }}">Utilizzo del portale</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>
