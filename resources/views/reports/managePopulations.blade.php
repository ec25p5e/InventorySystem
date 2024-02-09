@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creazione popolazione</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS')) }}">Report</a></li>
                        <li class="breadcrumb-item active">Gestione delle popolazioni di dati</li>
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
                <div class="box">
                    <div class="box-body">
                        <button type="button" class="btn btn-danger">
                            <i class="fas fa-trash"></i> <a href="{{ route(getRoute(Auth::id(), 'MANAGE_POPULATIONS')) }}" style="text-decoration:none;color:white"> Ripristina vista</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="box">
                    <div class="box-header">

                    </div>

                    <div class="box-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="search-input" placeholder="Cerca...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="searchTable()">Cerca</button>
                            </div>
                        </div>

                        <table class="table table-bordered display" id="tableTargetSearch">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nome</th>
                                    <th>Unità</th>
                                    <th>Utente di riferimento</th>
                                    <th>Utente di modifica</th>
                                    <th>Creato il...</th>
                                    <th>Modificato il...</th>
                                    <th style="width: 16%">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($populations as $population)
                                    <tr>
                                        <td>{{ $population->id }}</td>
                                        <td>{{ $population->population_name }}</td>
                                        <td>{{ getUnityCode($population->unity_id) }}</td>
                                        <td>{{ getUserById($population->user_id_ref) }}</td>
                                        <td>{{ getUserById($population->user_mod) }}</td>
                                        <td>{{ formatDateTime($population->created_at) }}</td>
                                        <td>{{ formatDateTime($population->updated_at) }}</td>
                                        <td>
                                            <button class="btn btn-warning">
                                                <i class="fas fa-edit"></i><a href="{{ route(getRoute(Auth::id(), 'MANAGE_POPULATIONS'), ['population_id' => $population->id]) }}" style="text-decoration:none; color:white">Seleziona</a>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                @if(Session::has('messageFormPopulation'))
                    <div class="alert alert-success">
                        {{ Session::get('messageFormPopulation') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Informazioni sulla popolazione</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route(getRoute(Auth::id(), 'STORE_POPULATION_EDIT')) }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="population_name">Nome della popolazione (*)</label>
                                            <input type="text" class="form-control" name="population_name" id="population_name" @isset($populationDetails->population_name) value="{{ $populationDetails->population_name }}" @endisset />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="unity_id">Disponibile sulla scuola (*): @isset($populationDetails->unity_id) <span style="color: red">{{ getUnityCode($populationDetails->unity_id) }}</span>@endisset </label>
                                            <select class="form-control" id="unity_id" name="unity_id">
                                                <option value="">Seleziona una scuola...</option>
                                                @isset($unities)
                                                    @foreach($unities as $unity)
                                                        <option value="{{ $unity->id }}">{{ $unity->unity_name }} ({{ $unity->unity_code }})</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="user_id">Utente proprietario: @isset($populationDetails->user_id_ref) <span style="color: red">{{ getUserById($populationDetails->user_id_ref) }}</span>@endisset </label>
                                            <select class="form-control" id="user_id" name="user_id">
                                                <option value="">Seleziona un'utente...</option>
                                                @isset($users)
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->unity_id }}">{{ $user->username }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">@isset($populationDetails) Aggiorna popolazione @else Crea popolazione @endisset</button>
                            </div>
                        </form>
                        <br>

                        @isset($populationDetails)
                            <div class="container box">
                                <div class="box-header">
                                    <h3 class="box-title">Filtri di ricerca</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table">
                                        <tr>
                                            <th scope="col" style="width:10px">#</th>
                                            <th scope="col">Codice filtro</th>
                                            <th scope="col">Operatore</th>
                                            <th scope="col">Filtro</th>
                                            <th scope="col">Azioni</th>
                                        </tr>

                                        <tr id="insertingRow">
                                            <form method="post" action="{{ route(getRoute(Auth::id(), 'STORE_POPULATION_FILTER')) }}">
                                                @csrf
                                                <input type="hidden" name="population_id" value="{{ $populationDetails->id }}" />

                                                <td></td>
                                                <td>
                                                    <div class="form-group has-feedback @error('code_ref') has-error @enderror">
                                                        <input type="text" name="code_ref" class="form-control">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="form-group has-feedback @error('filter_operator') has-error @enderror">
                                                        <select class="form-control" id="filter_operator" name="filter_operator">
                                                            <option value="" selected>Seleziona un'operatore</option>
                                                            <option value="=">Uguale</option>
                                                            <option value=">">Maggiore di</option>
                                                            <option value="<">Minore di</option>
                                                            <option value=">=">Maggiore uguale</option>
                                                            <option value="<=">Minore uguale</option>
                                                            <option value="!=">Diverso da</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group has-feedback @error('filter_value') has-error @enderror">
                                                        <input type="text" name="filter_value" class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-plus"></i> Aggiungi
                                                    </button>
                                                </td>
                                            </form>
                                        </tr>

                                        @isset($populationFilters)
                                            @foreach($populationFilters as $filter)
                                                <tr>
                                                    <td>{{ $filter->id }}</td>
                                                    <td>{{ $filter->code_ref }}</td>
                                                    <td>{{ $filter->filter_operator }}</td>
                                                    <td>{{ $filter->filter_value }}</td>
                                                    <td>
                                                        <button type="submit" class="btn btn-warning">
                                                            <i class="fas fa-edit"></i> Modifica
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash"></i> Elimina
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </table>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
