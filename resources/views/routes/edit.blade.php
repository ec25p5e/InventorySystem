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
                        <li class="breadcrumb-item">Modifica route</li>
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
                @isset($routeDetails)
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
                                                    <input type="text" class="form-control" name="route_code" value="{{ $routeDetails->route_code }}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('route_controller') has-error @enderror">
                                                <label for="route_controller">Controller della route</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="route_controller" value="{{ $routeDetails->route_controller }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('controller_method') has-error @enderror">
                                                <label for="controller_method">Metodo del controller</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="controller_method" value="{{ $routeDetails->controller_method }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('route_text') has-error @enderror">
                                                <label for="route_text">Nome da visualizzare</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="route_text" value="{{ $routeDetails->route_text }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('role_code') has-error @enderror">
                                                <label for="unity_code">Ruolo primario di riferimento: <span style="color:red">{{ getRoleName($routeDetails->role_id) }}</span></label>
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
                                                    <input type="text" class="form-control" name="route_name" value="{{ $routeDetails->route_name }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('route_method') has-error @enderror">
                                                <label for="route_method">Metodo: <span style="color:red">{{ $routeDetails->route_method }}</span></label>
                                                <select class="form-control" id="route_method" name="route_method">
                                                    <option value="get">GET</option>
                                                    <option value="post">POST</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group has-feedback @error('is_menu') has-error @enderror">
                                                <label for="route_method">Visibile nella barra di navigazione: <span style="color:red">{{ ($routeDetails->is_menu == 0) ? "No" : "Si" }}</span></label>
                                                <select class="form-control" id="is_menu" name="is_menu">
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 ml-3">
                                        <button type="submit" class="btn btn-primary">Aggiungi route</button>
                                        <button type="button" class="btn btn-danger"><a href="{{ URL::previous() }}" style="text-decoration:none;color:white">Scarta modifica</a></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </section>
@endsection
