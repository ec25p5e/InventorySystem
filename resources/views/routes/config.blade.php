@extends('layouts.app')

@section('css')
    body {
    margin-bottom: 6em;
    }
    .treeview .btn-default {
    border-color: #e3e5ef;
    }
    .treeview .btn-default:hover {
    background-color: #f7faea;
    color: #bada55;
    }
    .treeview ul {
    list-style: none;
    padding-left: 32px;
    }
    .treeview ul li {
    padding: 50px 0px 0px 35px;
    position: relative;
    }
    .treeview ul li:before {
    content: "";
    position: absolute;
    top: -26px;
    left: -31px;
    border-left: 2px dashed #a2a5b5;
    width: 1px;
    height: 100%;
    }
    .treeview ul li:after {
    content: "";
    position: absolute;
    border-top: 2px dashed #a2a5b5;
    top: 70px;
    left: -30px;
    width: 65px;
    }
    .treeview ul li:last-child:before {
    top: -22px;
    height: 90px;
    }
    .treeview > ul > li:after, .treeview > ul > li:last-child:before {
    content: unset;
    }
    .treeview > ul > li:before {
    top: 90px;
    left: 36px;
    }
    .treeview > ul > li:not(:last-child) > ul > li:before {
    content: unset;
    }
    .treeview > ul > li > .treeview__level:before {
    height: 60px;
    width: 60px;
    top: -9.5px;
    background-color: #54a6d9;
    border: 7.5px solid #d5e9f6;
    font-size: 22px;
    }
    .treeview > ul > li > ul {
    padding-left: 34px;
    }
    .treeview__level {
    padding: 7px;
    padding-left: 42.5px;
    display: inline-block;
    border-radius: 5px;
    font-weight: 700;
    border: 1px solid #e3e5ef;
    position: relative;
    z-index: 1;
    }
    .treeview__level:before {
    content: attr(data-level);
    position: absolute;
    left: -27.5px;
    top: -6.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 55px;
    width: 55px;
    border-radius: 50%;
    border: 7.5px solid #eef6d5;
    background-color: #bada55;
    color: #fff;
    font-size: 20px;
    }
    .treeview__level-btns {
    margin-left: 15px;
    display: inline-block;
    position: relative;
    }
    .treeview__level .level-same, .treeview__level .level-sub {
    position: absolute;
    display: none;
    transition: opacity 250ms cubic-bezier(0.7, 0, 0.3, 1);
    }
    .treeview__level .level-same.in, .treeview__level .level-sub.in {
    display: block;
    }
    .treeview__level .level-same.in .btn-default, .treeview__level .level-sub.in .btn-default {
    background-color: #faeaea;
    color: #da5555;
    }
    .treeview__level .level-same {
    top: 0;
    left: 45px;
    }
    .treeview__level .level-sub {
    top: 42px;
    left: 0px;
    }
    .treeview__level .level-remove {
    display: none;
    }
    .treeview__level.selected {
    background-color: #f9f9fb;
    box-shadow: 0px 3px 15px 0px rgba(0, 0, 0, 0.10);
    }
    .treeview__level.selected .level-remove {
    display: inline-block;
    }
    .treeview__level.selected .level-add {
    display: none;
    }
    .treeview__level.selected .level-same, .treeview__level.selected .level-sub {
    display: none;
    }
    .treeview .level-title {
    cursor: pointer;
    user-select: none;
    }
    .treeview .level-title:hover {
    text-decoration: underline;
    }
    .treeview--mapview ul {
    justify-content: center;
    display: flex;
    }
    .treeview--mapview ul li:before {
    content: unset;
    }
    .treeview--mapview ul li:after {
    content: unset;
    }
@endsection

@section('start_js')
    <script type="text/javascript">
        function generateRouteUri(routeName, element) {
            $(element).append('/' + routeName.replace(/\./g, "/"))
        }

        function deleteRouteInCreation() {

        }
    </script>
@endsection

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
                                        @include('partials.treeChild', ['unity' => $unity])
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
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('role_code') has-error @enderror">
                                                <label for="unity_code">Ruolo primario di riferimento</label>
                                                <select class="form-control" id="role_code" name="role_code">
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
                                    <th>URI della route</th>
                                    <th>Metodo d'accesso</th>
                                    <th>Controller</th>
                                    <th>Metodo del controller</th>
                                    <th style="width: 16%">Azioni</th>
                                </tr>

                                @isset($routes)
                                    @foreach($routes as $route)
                                        <tr>
                                            <td>{{ $route['auto_id'] }}</td>
                                            <td>{{ $route['route_code'] }}</td>
                                            <td>{{ getRoleName($route['role_code']) }}</td>
                                            <td>{{ getUnityName($route['unity_id']) }}</td>
                                            <td>{{ $route['route_name'] }}</td>
                                            <td id=`routeUri-`><script type="text/javascript">generateRouteUri('{{ $route['route_name'] }}', $('#routeUri-'))</script></td>
                                            <td>{{ $route['route_method'] }}</td>
                                            <td>{{ $route['route_controller'] }}</td>
                                            <td>{{ $route['controller_method'] }}</td>
                                            <td>
                                                <button class="btn btn-danger" onClick="deleteRouteInCreation({{ $route['auto_id'] }})">
                                                    <i class="fas fa-trash"></i>Elimina</a>
                                                </button>
                                            </td>
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

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
