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
                        <li class="breadcrumb-itema active">Gestione del routing dell'app</li>
                        <li class="breadcrumb-item">Elenco dei percorsi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Filtri di ricerca</h3>
            </div>
            <div class="box-body">
                <form method="get" action="{{ route(getRoute(Auth::id(), 'LIST_ROUTES')) }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group has-feedback ">
                                    <label for="unity_code">Unità di riferimento</label>
                                    <select class="form-control" id="unity_code" name="unity_code">
                                        <option value="" selected>Seleziona un'unità</option>
                                        @foreach($unities as $unity)
                                            <option value="{{ $unity->id }}">{{ $unity->unity_name }} ({{ $unity->unity_code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group has-feedback ">
                                    <label for="role_code">Ruolo di riferimento</label>
                                    <select class="form-control" id="role_code" name="role_code">
                                        <option value="" selected>Seleziona un ruolo</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }} ({{ $role->role_code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group has-feedback ">
                                    <label for="route_code">Codice univoco del percorso</label>
                                    <select class="form-control" id="route_code" name="route_code">
                                        <option value="" selected>Seleziona un codice route</option>
                                        @foreach($routes as $routeCode)
                                            <option value="{{ $routeCode }}">{{ $routeCode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Cerca</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Elenco dei percorsi secondo la ricerca...</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Codice univoco</th>
                        <th>Ruolo</th>
                        <th>Unità</th>
                        <th>Nome laravel</th>
                        <th>URL</th>
                        <th>Metodo</th>
                        <th>Controller</th>
                        <th>Metodo del controller</th>
                        <th>Middleware</th>
                        <th style="width: 16%">Azioni</th>
                    </tr>

                    @isset($results)
                        @foreach($results as $result)
                            <tr>
                                <td>{{ $result->id }}</td>
                                <td>{{ $result->route_code }}</td>
                                <td>{{ $result->route_role }}</td>
                                <td>{{ $result->route_unity }}</td>
                                <td>{{ $result->route_name }}</td>
                                <td>{{ $result->route_uri }}</td>
                                <td>{{ $result->route_method }}</td>
                                <td>{{ $result->route_controller }}</td>
                                <td>{{ $result->controller_method }}</td>
                                <td>{{ $result->route_middleware }}</td>
                                <td>
                                    <button class="btn btn-warning">
                                        <i class="fas fa-edit"></i> <a href="{{ route(getRoute(Auth::id(), 'ROUTE_UPDATE'), ['route_id' => $result->id]) }}" style="text-decoration:none; color: white;">Modifica</a>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </table>
            </div>
        </div>
    </section>
@endsection
