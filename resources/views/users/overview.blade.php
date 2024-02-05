@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $user->username }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Dettagli dell'utente</li>
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
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#anagrafica" role="tab">Dati base</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#address" role="tab">Indirizzi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#movements" role="tab">Economato (movimenti)</a>
                    </li>
                </ul>
            </div>

            <div class="box-body">
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
    </section>
@endsection
