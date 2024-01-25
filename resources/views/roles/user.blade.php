@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gestione ruoli utenti</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Gestione di sistema</a></li>
                        <li class="breadcrumb-item active">Gestione ruoli degli utenti</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <form action="" method="post">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Azioni</h3>
            </div>
            <div class="box-body">
                <div class="mb-3 ml-3">
                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                    <button type="button" class="btn btn-danger">Annulla modifiche</button>
                    <button type="button" class="btn btn-info">Aggiorna la vista</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Elenco dei ruoli</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" id="tableRoles">
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Nome ruolo</th>
                                <th>Numero utenti associati</th>
                            </tr>

                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td class="drag-handle"><i class="fas fa-arrows-alt"></i></td>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->role_name }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="box" id="tableUsersBox">
                    <div class="box-header">
                        <h3 class="box-title">Elenco degli utenti</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" id="tableUsers">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Email</th>
                                <th>Ruoli associati</th>
                            </tr>

                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#tableRoles tbody").sortable({
                handle: '.drag-handle',
                connectWith: "#tableUsers tbody",
                placeholder: 'ui-state-highlight',
                tolerance: 'pointer',
                cursor: 'move',
                over: function(event, ui) {
                    $("#tableUsersBox").addClass("box-border-highlight");
                },
                out: function(event, ui) {
                    $("#tableUsersBox").removeClass("box-border-highlight");
                }
            }).disableSelection();
        });
    </script>
@endsection


