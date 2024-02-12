@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Elenco dei percorsi del programma</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                        <li class="breadcrumb-item">Elenco dei percorsi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary pull-right">
                            <i class="fas fa-tick"></i> <a style="text-decoration:none; color:white" href="{{ route(getRoute(Auth::id(), 'ROUTE_CREATE')) }}">Nuova route</a>
                        </button>
                        <button type="button" class="btn btn-danger pull-right">
                            <i class="fas fa-trash"></i> <a style="text-decoration:none; color:white" href="{{ route(getRoute(Auth::id(), 'LIST_ROUTES')) }}">Ripristina vista</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Selezionare l'unità</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Filtrare per ruolo</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th scope="col">Ruolo</th>
                                    <th scope="col">Azioni</th>
                                </tr>

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
                            </table>
                        </div>
                    </div>
                </div>
            @endisset
        </div>

        @if($routes !== null)
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Elenco dei percorsi per unità</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered" id="dataTablesStandard">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
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
                                        <th style="width: 16%">Azioni</th>
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
    </section>
@endsection


@section('js')
    @parent

    <script>
        $(function () {
            $("#dataTablesStandard").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            });
        });
    </script>
@endsection
