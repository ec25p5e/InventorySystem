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
                        <form action="{{ route(getRoute(Auth::id(), 'SEARCH_PRODUCT')) }}" method="post" name="form-product">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="product_num_ceap">Numero CEAP (*)</label>
                                            <input type="text" class="form-control" name="product_num_ceap" id="liveSearch product_num_ceap" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="product_name">Nome prodotto</label>
                                            <input type="text" class="form-control" name="product_name" id="product_name"   />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Entrate</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="tableRoles">
                        <tr>
                            <th>#</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box" id="tableUsersBox">
                <div class="box-header">
                    <h3 class="box-title">Uscite</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="tableUsers">
                        <tr>
                            <th style="width: 10px">#</th>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>

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
