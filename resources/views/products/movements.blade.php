@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Movimenti</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(getRoute(Auth::id(), 'DASHBOARD')) }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS')) }}">Prodotti</a></li>
                        <li class="breadcrumb-item active">Movimenti</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-header">
                        <h3 class="box-title">Scansione prodotto</h3>
                    </div>
                </div>

                <div class="box-body">
                    <div id="barcode-scanner">
                        <div id="barcode-camera"></div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-header">
                        <h3 class="box-title">Prodotto scansionato</h3>
                    </div>
                </div>

                <div class="box-body">
                    <div id="barcode-scanner">
                        <div id="barcode-result"></div>
                        <form action="{{ route(getRoute(Auth::id(), 'LIST_OF_MOVEMENTS')) }}" method="get" name="form-product">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="product_num_ceap">Numero CEAP (*)</label>
                                            <input type="text" class="form-control" name="product_num_ceap" id="liveSearch product_num_ceap" @isset($formFields['product_num_ceap']) value="{{$formFields['product_num_ceap']}}" @endisset />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="product_name">Nome prodotto</label>
                                            <input type="text" class="form-control" name="product_name" id="product_name" @isset($formFields['product_name']) value="{{$formFields['product_name']}}" @endisset  />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success align-right">Cerca prodotto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dettagli del prodotto</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Numero CEAP</th>
                            <th>Numero C&C</th>
                            <th>Numero interno</th>
                            <th>Nome</th>
                            <th>Stato</th>
                            <th class="bg-secondary">Scuola</th>
                            <th style="width: 16%">Azioni</th>
                        </tr>

                         @isset($listOfProducts)
                            @foreach($listOfProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_num_ceap }}</td>
                                    <td id="ccTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'C&C_NUM', $('#ccTd-{{ $product->id }}'))</script></td>
                                    <td>{{ $product->product_num_intern }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ (($product->product_end == getSettings('DEFAULT_DATE_END')) || $product->product_end == null) ? "Attivo" : "Inutilizzato" }}</td>
                                    <td id="unityRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'UNITY', $('#unityRefTd-{{ $product->id }}'))</script></td>
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
                        @endisset

                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Timeline della quantità</h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">
                        @isset($timelineDates)
                            @foreach($timelineDates as $date)
                                <div class="time-label">
                                    <span class="bg-green">{{ $date->attribute_date }}</span>
                                </div>

                                @foreach($moveForDate($date->attribute_date) as $move)
                                    <p></p>
                                    <div>
                                        <i class="fas fa-envelope {{ ($move->attribute_log == "DECREMENT") ? "bg-danger" : "bg-info" }}"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-solid fa-right-from-bracket"></i> {{ formatDateTime($move->attribute_date_start) }}</span>
                                            <h3 class="timeline-header"><a href="#">{{ getUserById($move->user_id) }}</a> {{ ($move->attribute_log == "DECREMENT") ? " ha prelevato dal " : " ha aggiunto al" }} magazzino</h3>
                                            <div class="timeline-body">
                                                Sono
                                                {{ ($move->attribute_log == "DECREMENT") ? " stati sottratti " : " stati aggiunti " }}
                                                5
                                                prodotti
                                            </div>
                                        </div>
                                    </div>
                                    <p></p>
                                @endforeach
                            @endforeach
                        @endisset
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#barcode-camera'),
                constraints: {
                    facingMode: "environment"
                }
            },
            decoder: {
                readers: ["ean_reader", "ean_8_reader", "code_128_reader", "upc_reader"]
            }
        }, function(err) {
            if (err) {
                console.error(err);
                return;
            }
            console.log("QuaggaJS initialized");

            Quagga.start();
        });

        Quagga.onDetected(function(result) {
            let csrfToken = "{{ csrf_token() }}";
            let code = result.codeResult.code;
            alert(code)
            document.querySelector('#barcode-result').textContent = code;

            $.ajax({
                url: '/api/processProductBarcode',
                type: 'POST',
                dataType: 'json',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': code
                },
                success: function (risposta) {
                    console.log('Chiamata API riuscita:', risposta);
                },
                error: function (xhr, status, error) {
                    console.error('Errore nella chiamata API:', error);
                }

            });
        });
    </script>
@endsection
