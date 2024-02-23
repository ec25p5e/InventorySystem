@extends('layouts.app')

@section('body')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Utenti</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route(getRoute(Auth::id(), 'DASHBOARD')) }}">{{ getUnityName(getUserActualUnity(Auth::id())) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Dettagli dell'utente
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12">
                <div class="card card-box">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#anagrafica">Dati di base</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#address">Indirizzi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#movements">Economato (movimenti)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="anagrafica" role="tabpanel">
                                <form action="" method="post" name="form-product">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="first_name">Nome (*)</label>
                                                    <input type="text" class="form-control" name="first_name" id="first_name" @isset($user->first_name) value="{{ $user->first_name }}" @endisset />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="last_name">Cognome (*)</label>
                                                    <input type="text" class="form-control" name="last_name" id="last_name" @isset($user->last_name) value="{{ $user->last_name }}" @endisset />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" @isset($user->email) value="{{ $user->email }}" @endisset />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="password">Password (*)</label>
                                                    <input type="text" class="form-control" name="password" id="password" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Salva dati base</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade show" id="address" role="tabpanel">
                                <form action="" method="post" name="form-address">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="address">Indirizzo completo</label>
                                                    <input type="text" class="form-control" name="address" id="address-{{ $user->id }}" value="" />
                                                    <script>loadUnityInformation({{ $user->id }}, 'user_attributes', 'ADDRESS', $('#address-{{ $user->id }}'), false)</script>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="locality">Località</label>
                                                    <input type="text" class="form-control" name="locality" id="locality-{{ $user->id }}" />
                                                    <script>loadUnityInformation({{ $user->id }}, 'user_attributes', 'LOCALITY', $('#locality-{{ $user->id }}'), false)</script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="locality">CAP</label>
                                                    <input type="text" class="form-control" name="cap" id="cap-{{$user->id}}" />
                                                    <script>loadUnityInformation({{ $user->id }}, 'user_attributes', 'CAP', $('#cap-{{$user->id}}'), false)</script>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="nationality">Nazione</label>
                                                    <input type="text" class="form-control" name="nationality" id="nationality-{{$user->id}}" />
                                                    <script>loadUnityInformation({{ $user->id }}, 'user_attributes', 'NATIONALITY', $('#nationality-{{$user->id}}'), false)</script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Salva dati indirizzo</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="movements" role="tabpanel">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Prodotto</th>
                                        <th>Scuola</th>
                                        <th>Movimento</th>
                                        <th>Quantità</th>
                                        <th>Registrato il...</th>
                                    </tr>

                                    @isset($movements)
                                        @foreach($movements as $movement)
                                            <tr>
                                                <td>{{ $movement->id }}</td>
                                                <td>{{ $movement->product_name }}</td>
                                                <td>{{ $movement->unity }}</td>
                                                <td>{{ ($movement->attribute_log == 'DECREMENT') ? "Prelievo" : "Versamento" }}</td>
                                                <td>{{ $movement->attribute_log_detail }}</td>
                                                <td>{{ formatDateTime($movement->registred_at) }}</td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
