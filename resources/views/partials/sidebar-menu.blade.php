<li class="dropdown" data-menu-id="{{ $route->route_code }}">
    <a href="" class="dropdown-toggle"><span class="micon bi bi-house"></span><span class="mtext">{{ $route->route_text }}</span>
    </a>
    <ul class="submenu">
        <li><a href="index.html">Dashboard style 1</a></li>
        <li><a href="index2.html">Dashboard style 2</a></li>
        <li><a href="index3.html">Dashboard style 3</a></li>
    </ul>

    @if($unity->childrenRecursive)
        <ul>
            @foreach($unity->childrenRecursive as $child)
                @include('partials.treeChild', ['unity' => $child])
            @endforeach
        </ul>
    @endif
</li>
