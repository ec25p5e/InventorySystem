@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gestione utenti</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Elenco degli utenti</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <section class="content">
        <div class="box">
            <div class="box-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary mr-3">
                        <a style="text-decoration: none; color: white;" href="{{ route(getRoute(Auth::id(), 'CREATE_NEW_USER_COMPLETE')) }}">Nuovo utente</a>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th>Nome completo</th>
                        <th>Unità</th>
                        <th style="width: 16%">Azioni</th>
                    </tr>

                    @isset($users)
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->unity_name }}</td>
                                <td>
                                    <button class="btn btn-warning">
                                        <i class="fas fa-edit"></i> <a href="{{ route(getRoute(Auth::id(), 'USER_DETAILS_PANE'), ['user_id' => $user->id]) }}" style="text-decoration:none; color: white;">Modifica</a>
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
