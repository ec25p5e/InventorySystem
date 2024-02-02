@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creazione utente completa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Elenco utenti</a></li>
                        <li class="breadcrumb-item active">Creazione completa utente</li>
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
                <h3 class="box-title">Form per la creazione di un nuovo utente + assegnazione della chiave/badge</h3>
            </div>
            <div class="box-body">
                <form action="" method="post" name="form-product">
                    @csrf
                    <h4>Dati anagrafici</h4>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="first_name">Nome (*)</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="last_name">Cognome (*)</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"   />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="password">Password (*)</label>
                                    <input type="text" class="form-control" name="password" id="password"   />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="address">Indirizzo completo</label>
                                    <input type="text" class="form-control" name="address" id="address" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="locality">Località</label>
                                    <input type="text" class="form-control" name="locality" id="locality" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="locality">CAP</label>
                                    <input type="text" class="form-control" name="cap" id="cap" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="nationality">Nazione</label>
                                    <input type="text" class="form-control" name="nationality" id="nationality" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4>Dati fiscali</h4>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="iban">IBAN</label>
                                    <input type="text" class="form-control" name="iban" id="iban"   />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="institute">Istituto (Swift/Bic)</label>
                                    <input type="text" class="form-control" name="institute" id="institute"   />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4>Assegnazione delle chiavi => consegna</h4>

                    <table class="table m-5">
                        <thead>
                            <tr>
                                <th scope="col">Codice attributo</th>
                                <th scope="col">Valore</th>
                                <th scope="col">Copiabile?</th>
                                <th scope="col">Aggiornato il</th>
                                <th scope="col">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <!-- <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="unity_ref">Servizio presso</label>
                                    <select class="form-control" id="unity_ref" name="unity_ref">
                                        <option value=""
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="date">Data consegna chiavi</label>
                                    <input type="date" class="form-control" name="date" id="date" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="time">Data consegna chiavi</label>
                                    <input type="time" class="form-control" name="time" id="time" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_color">Colore</label>
                                    <input type="text" class="form-control" name="key_color" id="key_color" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_color">Numero</label>
                                    <input type="text" class="form-control" name="key_number" id="key_number" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_quantity">Quantità</label>
                                    <input type="text" class="form-control" name="key_quantity" id="key_quantity" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_support_code">Codice supporto</label>
                                    <input type="text" class="form-control" name="key_support_code" id="key_support_code" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_deposit">Cauzione</label>
                                    <input type="text" class="form-control" name="key_deposit" id="key_deposit" />
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <h4>Assegnazione delle chiavi => riconsegna</h4>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_reconsigned_date">Riconsegnata il</label>
                                    <input type="date" class="form-control" name="key_reconsigned_date" id="key_reconsigned_date" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_reconsigned_status">Stato</label>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_reconsigned_oss">Osservazioni</label>
                                    <input type="text" class="form-control" name="key_reconsigned_oss" id="key_reconsigned_oss" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4>Riconsegna cauzione</h4>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="key_iban_do_date">Versamento effettuato in data...</label>
                                    <input type="date" class="form-control" name="key_iban_do_date" id="key_iban_do_date" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4>Perdita chiavi</h4>
                </form>
            </div>
        </div>
    </section>
@endsection
