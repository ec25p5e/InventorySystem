@extends('layouts.app')

@section('body')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Economato</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route(getRoute(Auth::id(), 'DASHBOARD')) }}">{{ getUnityName(getUserActualUnity(Auth::id())) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Movimenti degli articoli
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
                                Opzioni
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:;">Nuovo utente</a>
                                <a id="startHelp" class="dropdown-item" href="javascript:;">Aiuto</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <div class="row" id="helpSearchMovements">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4 class="text-blue h4" >Elenco degli utenti</h4>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 d-flex justify-content-end align-items-center">
                            <a href="#" class="help-icon"><i onclick="startHelpSequence()" class="dw dw-help"></i></a>
                        </div>
                    </div>
                </div>

                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort" >#</th>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Email</th>
                                <th>Nome completo</th>
                                <th>Unità</th>
                                <th class="datatable-nosort">Azioni</th>
                            </tr>
                        </thead>

                        <tbody>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



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

            </div>
        </div>
    </section>
@endsection
