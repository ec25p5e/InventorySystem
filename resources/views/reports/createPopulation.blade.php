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
                        <li class="breadcrumb-item"><a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS')) }}">Popolazioni di dati</a></li>
                        <li class="breadcrumb-item active">Creazione popolazione</li>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="population_name">Nome della popolazione (*)</label>
                                            <input type="text" class="form-control" name="population_name" id="population_name" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="unity_id">Disponibile sulla scuola (*): @isset($reportDetails->unity_id) <span style="color: red">{{ getUnityName($reportDetails->unity_id) }}</span>@endisset </label>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="user_id">Utente proprietario: @isset($reportDetails->user_id) <span style="color: red">{{ getUserById($reportDetails->user_id) }}</span>@endisset </label>
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
                                <button type="submit" class="btn btn-primary">Crea popolazione</button>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
