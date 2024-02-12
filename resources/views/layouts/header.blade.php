<div class="modal fade" id="changeUnityRefModal" tabindex="-1" role="dialog" aria-labelledby="Cambia scuola" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Dalla scuola: <span style="color: red;">{{ getCurrentUnityForUser(Auth::id()) }}</span> a...</h4><p></p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route(getRoute(Auth::id(), 'CHANGE_UNITY_REF')) }}">
                    @csrf

                    <div class="form-group">
                        <label for="unity_ref" class="form-label">Seleziona una scuola</label>
                        <select class="form-control" id="unity_ref" name="unity_ref">
                            @foreach(getUserUnities(Auth::id()) as $unity)
                                <option value="{{ $unity->id }}">{{ $unity->unity_name }} ({{ $unity->unity_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success align-right">Accedi</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>


<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @if(getNotifications(Auth::id())->count() > 0)
                    @foreach(getNotifications(Auth::id()) as $notify)
                        <a href="" class="dropdown-item">
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        {{ $notify->notification_title }}
                                    </h3>
                                    <p class="text-sm">{{ $notify->notification_message }}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ formatDateTime($notify->created_at) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif

                <span class="dropdown-item dropdown-header"><a href="{{ route(getRoute(Auth::id(), 'ALL_NOTIFICATIONS')) }}">Mostra tutte</a></span>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Menu utente</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profilo
                </a>

                <button class="dropdown-item" data-toggle="modal" data-target="#changeUnityRefModal">
                    <i class="fas fa-solid fa-building"></i> Cambia scuola
                </button>

                <div class="dropdown-divider"></div>
                <a href="{{ route(getRoute(Auth::id(), 'LOGOUT')) }}" class="dropdown-item dropdown-footer">Sign out</a>
            </div>
        </li>
    </ul>
</nav>
