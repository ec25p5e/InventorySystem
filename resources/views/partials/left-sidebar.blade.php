@php
    $current_route = request()->route()->getName();
@endphp


<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html">
            <img src="{{ asset('template/images/deskapp-logo.svg') }}" alt="" class="dark-logo" />
            <img
                src="vendors/images/deskapp-logo-white.svg"
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
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>
