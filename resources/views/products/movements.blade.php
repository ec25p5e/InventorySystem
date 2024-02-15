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
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4 class="text-blue h4">Ricerca articolo</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <form action="{{ route(getRoute(Auth::id(), 'LIST_OF_MOVEMENTS')) }}" method="get" name="form-product">
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="product_barcode">Barcode</label>
                                        <input type="text" class="form-control" name="product_barcode" id="product_barcode" @isset($formFields['product_barcode']) value="{{$formFields['product_barcode']}}" @endisset />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="product_num_ceap">Numero CEAP</label>
                                        <input type="text" class="form-control" name="product_num_ceap" id="product_num_ceap" @isset($formFields['product_num_ceap']) value="{{$formFields['product_num_ceap']}}" @endisset />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="product_name">Nome prodotto</label>
                                        <input type="text" class="form-control" name="product_name" id="product_name" @isset($formFields['product_name']) value="{{$formFields['product_name']}}" @endisset  />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Ricerca articolo</button>
                    </form>
                </div>
            </div>

            @isset($listOfProducts)
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="title">
                                    <h4 class="text-blue h4">Risultati della ricerca</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pd-20 card-box mb-30">
                        <table class="table table-bordered" id="dataTablesStandard">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Numero CEAP</th>
                                <th>Numero C&C</th>
                                <th>Numero interno</th>
                                <th>Nome</th>
                                <th>Stato</th>
                                <th class="bg-secondary">Scuola</th>
                                <th class="bg-secondary">Quantità </th>
                                <th style="width: 16%">Azioni</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($listOfProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_num_ceap }}</td>
                                    <td id="ccTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'C&C_NUM', $('#ccTd-{{ $product->id }}'))</script></td>
                                    <td>{{ $product->product_num_intern }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ (($product->product_end == getSettings('DEFAULT_DATE_END')) || $product->product_end == null) ? "Attivo" : "Inutilizzato" }}</td>
                                    <td id="unityRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'UNITY', $('#unityRefTd-{{ $product->id }}'))</script></td>
                                    <td id="qtyRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'QTY', $('#qtyRefTd-{{ $product->id }}'))</script></td>
                                    <td>
                                        <button class="btn btn-success">
                                            <i class="fas fa-check"></i>
                                            <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_MOVEMENTS'), [
                                                'product_id' => $product->id,
                                                'product_num_ceap' => isset($formFields['product_num_ceap']) > 0 ? $formFields['product_num_ceap'] : "",
                                                'product_name' => isset($formFields['product_name']) > 0 ? $formFields['product_name'] : ""
                                            ]) }}" style="text-decoration:none; color: white;"> Seleziona</a>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card-box mb-30">
                            <div class="pd-20">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="title">
                                            <h4 class="text-blue h4">Timeline della quantità</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pd-20 card-box mb-30">
                                <div class="timeline timeline-inverse">
                                    @isset($timelineDates)
                                        <ul>
                                            @foreach($timelineDates as $date)
                                                <li>
                                                    <div class="timeline-date">{{ formatDatePortal($date->attribute_date) }}</div>

                                                    @foreach($moveForDate($date->attribute_date) as $move)
                                                        <div class="timeline-desc card-box">
                                                            <div class="pd-20">
                                                                <h4 class="mb-10 h4">
                                                                    Il prodotto {{ ($move->attribute_log == "DECREMENT") ? "è stato prelevato" : "è stato depositato" }}
                                                                </h4>
                                                                <p>
                                                                    <a style="color: red; font-weight: bold" href="{{ route(getRoute(Auth::id(), 'USER_DETAILS_PANE'), ['user_id' => $move->user_id]) }}">{{ getUserById($move->user_id) }}</a>
                                                                    ha
                                                                    {{ ($move->attribute_log == "DECREMENT") ? "prelevato" : "depositato" }}
                                                                    {{ $move->attribute_log_detail }}
                                                                    articoli
                                                                    Ne rimangono:
                                                                    {{ $move->attribute_value }} }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <p></p>
                                                    @endforeach
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        @isset($timelineDates)
                            <div class="card-box mb-30">
                                <div class="pd-20">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="title">
                                                <h4 class="text-blue h4">Registra nuovo movimento</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pd-20 card-box mb-30">
                                    <form action="{{ route(getRoute(Auth::id(), 'EDIT_PRODUCT_ATTR_QTY')) }}" method="post" name="form-product">
                                        @csrf
                                        <input type="hidden" name="attribute_code" value="QTY" />
                                        <input type="hidden" name="product_ref_id" value="{{ $productId }}" />
                                        <input type="hidden" name="attribute_hidden" value="1" />

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                        <label for="attribute_log">Movimento</label>
                                                        <select class="form-control" id="attribute_log" name="attribute_log">
                                                            <option value="" selected>Seleziona un'opzione...</option>
                                                            <option value="INCREMENT">Incremento (entrata)</option>
                                                            <option value="DECREMENT">Decremento (uscita)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                        <label for="attribute_value">Differenza di materiale (incremento o decremento)</label>
                                                        <input type="text" class="form-control" name="attribute_value" id="attribute_value" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                        <label for="user_id">Per conto di...</label>
                                                        <select class="form-control" id="user_id" name="user_id">
                                                            <option value="" selected>Seleziona un'opzione...</option>
                                                            @isset($teachers)
                                                                @foreach($teachers as $teacher)
                                                                    <option value="{{ $teacher->id }}">{{ $teacher->username }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Registra</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection
