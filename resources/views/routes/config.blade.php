@extends('layouts.app')


@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Percorsi del programma</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{ URL::previous() }}">Gestione del routing dell'app</a></li>
                        <li class="breadcrumb-item">Creazione route</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Selezionare le unità</h3>
                    </div>
                    <div class="box-body">
                        <div class="treeview js-treeview">
                            <ul>
                                @isset($unities)
                                    @foreach($unities as $unity)
                                        @include('partials.treeChild', ['unity' => $unity, 'route' => 'CREATE_ROUTE'])
                                    @endforeach
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($parameters['unity_id']))
                <div class="col-md-9">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Form per la creazione delle route</h3>
                        </div>
                        <div class="box-body">
                            <form method="get" action="{{ route(getRoute(Auth::id(), 'ROUTE_CREATE')) }}" name="form-product">
                                @csrf

                                <input type="hidden" name="unity_id" @isset($parameters['unity_id']) value="{{ $parameters['unity_id'] }}" @endisset />

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('route_code') has-error @enderror">
                                                <label for="route_code">Codice univoco d'indentificazione della route</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="route_code" @isset($parameters['route_code']) value="{{ $parameters['route_code'] }}" readonly @endisset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('route_controller') has-error @enderror">
                                                <label for="route_controller">Controller della route</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="route_controller" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('controller_method') has-error @enderror">
                                                <label for="controller_method">Metodo del controller</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="controller_method" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('route_text') has-error @enderror">
                                                <label for="route_text">Nome da visualizzare</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="route_text" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('role_code') has-error @enderror">
                                                <label for="unity_code">Ruolo primario di riferimento</label>
                                                <select class="form-control" id="role_code" name="role_code">
                                                    <option value="" selected>Seleziona un ruolo</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role_name }} ({{ $role->role_code }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('route_name') has-error @enderror">
                                                <label for="route_code">Nome della route</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="route_name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('route_method') has-error @enderror">
                                                <label for="route_method">Metodo</label>
                                                <select class="form-control" id="route_method" name="route_method">
                                                    <option value="get">GET</option>
                                                    <option value="post">POST</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('is_menu') has-error @enderror">
                                                <label for="route_method">Visibile nella barra di navigazione</label>
                                                <select class="form-control" id="is_menu" name="is_menu">
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 ml-3">
                                        <button type="submit" class="btn btn-primary" name="btnForm" value="1">Aggiungi route</button>
                                        <button type="submit" class="btn btn-secondary" name="btnForm" value="2">Propaga</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if(isset($parameters['unity_id']))
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Elenco delle route in fase di creazione</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Codice univoco</th>
                                    <th>Ruolo</th>
                                    <th>Sede scolastica</th>
                                    <th>Nome della route</th>
                                    <th>Metodo d'accesso</th>
                                    <th>Controller</th>
                                    <th>Metodo del controller</th>
                                </tr>

                                @isset($routes)
                                    @foreach($routes as $route)
                                        <tr>
                                            <td>{{ $route['auto_id'] }}</td>
                                            <td>{{ $route['route_code'] }}</td>
                                            <td>{{ getRoleName($route['role_code']) }}</td>
                                            <td>{{ getUnityCode($route['unity_id']) }}</td>
                                            <td>{{ $route['route_name'] }}</td>
                                            <td>{{ $route['route_method'] }}</td>
                                            <td>{{ $route['route_controller'] }}</td>
                                            <td>{{ $route['controller_method'] }}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="mb-3 mr-3">
                                    <form method="post" action="{{ route(getRoute(Auth::id(), 'SAVE_NEW_ROUTE')) }}">
                                        @csrf

                                        <button type="submit" class="btn btn-primary">Crea route</button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="mb-3 mr-3">
                                    <button type="button" class="btn btn-danger"><a style="text-decoration:none; color: white;" href="{{ route(getRoute(Auth::id(), 'ROUTE_CREATE')) }}">Ripristina vista</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
