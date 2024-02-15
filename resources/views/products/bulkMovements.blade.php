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
                                    Movimenti in blocco
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4 class="text-blue h4">Impostazioni di lavoro</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <form action="{{ route(getRoute(Auth::id(), 'BULK_MOVEMENTS')) }}" method="get" name="form-product">
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="type_of_movements">Tipo di movimento</label>
                                        <select class="form-control" id="type_of_movements" name="type_of_movements">
                                            <option value="" selected>Seleziona modalità</option>
                                            <option value="DECREMENT">Decrementa (prelevare)</option>
                                            <option value="INCREMENT">Incrementa (aggiungere)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="user_register">Utente registrante: <span style="font-weight: bold; color: red">{{ getUserById((isset($key) ? $key['user_register'] : Auth::id())) }}</span></label>
                                        <select class="form-control" id="user_register" name="user_register">
                                            <option value="{{ (isset($key)  ? $key['user_register'] : Auth::id()) }}" selected>{{ getUserById((isset($key) ? $key['user_register'] : Auth::id())) }}</option>
                                            @isset($users_register)
                                                @foreach($users_register as $user)
                                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Salva impostazioni</button>
                    </form>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4 class="text-blue h4">Tabella dei riscontri</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <form action="{{ route(getRoute(Auth::id(), 'BULK_MOVEMENTS')) }}" method="get" name="form-product">
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="type_of_movements">Tipo di movimento</label>
                                        <select class="form-control" id="type_of_movements" name="type_of_movements">
                                            <option value="" selected>Seleziona modalità</option>
                                            <option value="DECREMENT">Decrementa (prelevare)</option>
                                            <option value="INCREMENT">Incrementa (aggiungere)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="user_register">Utente registrante: <span style="font-weight: bold; color: red">{{ getUserById((isset($key) ? $key['user_register'] : Auth::id())) }}</span></label>
                                        <select class="form-control" id="user_register" name="user_register">
                                            <option value="{{ (isset($key)  ? $key['user_register'] : Auth::id()) }}" selected>{{ getUserById((isset($key) ? $key['user_register'] : Auth::id())) }}</option>
                                            @isset($users_register)
                                                @foreach($users_register as $user)
                                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Salva impostazioni</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
