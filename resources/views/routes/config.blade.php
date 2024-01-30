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
                        <li class="breadcrumb-itema active">Gestione del routing dell'app</li>
                        <li class="breadcrumb-item">Creazione route</li>
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
                <h3 class="box-title">Form per la creazione delle route</h3>
            </div>
            <div class="box-body">
                <form  method="post" name="form-product">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group has-feedback @error('unity_code') has-error @enderror">
                                    <label for="unity_code">Unità di riferimento della route</label>
                                    <select class="form-control" id="unity_code" name="unity_code">
                                        @foreach($unities as $unity)
                                            <option value="{{ $unity->id }}">{{ $unity->unity_name }} ({{ $unity->unity_code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-group has-feedback @error('route_code') has-error @enderror">
                                    <label for="route_code">Codice univoco d'indentificazione della route</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="route_code">
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
                                <div class="form-group has-feedback @error('route_value') has-error @enderror">
                                    <label for="route_code">Percorso della route (URL)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="route_value">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 ml-3">
                            <button type="submit" class="btn btn-primary">Invia dati</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
