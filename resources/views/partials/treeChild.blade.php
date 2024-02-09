<li data-node-id="{{ $unity->id }}">
    <div class="treeview__level" data-level="{{ $unity->unity_code }}">
        <span class="level-title"><a href="{{ route(getRoute(Auth::id(), $route), ['unity_id' => $unity->id]) }}">{{ $unity->unity_name }}</a></span>
    </div>
    @if($unity->childrenRecursive)
        <ul>
            @foreach($unity->childrenRecursive as $child)
                @include('partials.treeChild', ['unity' => $child])
            @endforeach
        </ul>
    @endif
</li>
