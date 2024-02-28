@extends('layouts.app')

@section('body')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Gestione sistema</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route(getRoute(Auth::id(), 'DASHBOARD')) }}">{{ getUnityName(getUserActualUnity(Auth::id())) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Elenco delle route
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="dropdown">
                            <a
                                class="btn btn-primary dropdown-toggle"
                                href="#"
                                role="button"
                                data-toggle="dropdown"
                            >
                                Altre azioni
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a style="text-decoration:none; color:white" href="{{ route(getRoute(Auth::id(), 'ROUTE_CREATE')) }}">Nuova route</a>
                                <a style="text-decoration:none; color:white" href="{{ route(getRoute(Auth::id(), 'LIST_ROUTES')) }}">Ripristina vista</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <h4 class="text-blue h4">
                                Selezionare l'unità
                            </h4>
                        </div>

                        <div class="pd-20 card-box mb-30">
                            <div class="treeview js-treeview">
                                <ul>
                                    @isset($unities)
                                        @foreach($unities as $unity)
                                            @include('partials.treeChild', ['unity' => $unity, 'route' => 'ROUTE_CONF'])
                                        @endforeach
                                    @endisset
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($parameters))
                    <div class="col-md-6">
                        <div class="card-box mb-30">
                            <div class="pd-20">
                                <h4 class="text-blue h4">
                                    Filtrare per ruolo
                                </h4>
                            </div>

                            <div class="pd-20 card-box mb-30">
                                <table class="data-table table stripe hover nowrap">
                                    <thead>
                                        <tr>
                                            <th class="table-plus datatable-nosort">#</th>
                                            <th scope="col">Ruolo</th>
                                            <th scope="col" class="datatable-nosort">Azioni</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @isset($roles)
                                            @foreach($roles as $role)
                                                <tr>
                                                    <td>{{ $role->id }}</td>
                                                    <td>{{ $role->role_name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success">
                                                            <i class="fas fa-tick"></i> <a style="text-decoration:none; color:white" href="{{ route(getRoute(Auth::id(), 'ROUTE_CONF'), ['unity_id' => $parameters['unity_id'], 'role_id' => $role->id]) }}">Seleziona</a>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if($routes !== null)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box mb-30">
                            <div class="pd-20">
                                <h4 class="text-blue h4">
                                    Elenco delle route per unità e per ruolo
                                </h4>
                            </div>

                            <div class="pd-20 card-box mb-30">
                                <table class="data-table table stripe hover nowrap">
                                    <thead>
                                        <tr>
                                            <th class="table-plus datatable-nosort">#</th>
                                            <th>Codice univoco</th>
                                            <th>Nome da visualizzare</th>
                                            <th>Ruolo</th>
                                            <th>Unità</th>
                                            <th>Nome laravel</th>
                                            <th>URL</th>
                                            <th>Metodo</th>
                                            <th>Controller</th>
                                            <th>Metodo del controller</th>
                                            <th>Middleware</th>
                                            <th>Visibile nel menu?</th>
                                            <th class="datatable-nosort">Azioni</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @isset($routes)
                                            @foreach($routes as $route)
                                                <tr>
                                                    <td>{{ $route->id }}</td>
                                                    <td>{{ $route->route_code }}</td>
                                                    <td>{{ $route->route_text }}</td>
                                                    <td>{{ getRoleName($route->role_id) }}</td>
                                                    <td>{{ getUnityName($route->unity_id) }}</td>
                                                    <td>{{ $route->route_name }}</td>
                                                    <td>{{ $route->route_uri }}</td>
                                                    <td>{{ $route->route_method }}</td>
                                                    <td>{{ $route->route_controller }}</td>
                                                    <td>{{ $route->controller_method }}</td>
                                                    <td>{{ $route->route_middleware }}</td>
                                                    <td>{{ ($route->is_menu == 0) ? "No" : "Si" }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                            <a style="text-decoration:none; color:white" href="{{ route(getRoute(Auth::id(), 'EDIT_ROUTE'), ['route_id' => $route->id]) }}">
                                                                Modifica
                                                            </a>
                                                        </button>

                                                        <button type="button" class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>Seleziona</a>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
