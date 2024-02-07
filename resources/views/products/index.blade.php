@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Elenco prodotti</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Elenco prodotti</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <section class="content">
        <div class="box">
            <div class="box-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary mr-3">
                        <a style="text-decoration: none; color: white;" href="{{ route(getRoute(Auth::id(), 'NEW_PRODUCTS_FORM')) }}">Nuovo prodotto</a>
                    </button>

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="optionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opzioni
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="optionsDropdown">
                            @if($showLess == 1)
                                <a class="dropdown-item" href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS'), ['filters' => '?showLess=0']) }}">Mostra tutti i prodotti</a>
                            @else
                                <a class="dropdown-item" href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS'), ['filters' => '?showLess=1']) }}">Mostra prodotti in esaurimento</a>
                            @endif

                            @if($showTerminateProducts == 1)
                                    <a class="dropdown-item" href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS'), ['filters' => '?showTerminateProducts=0']) }}">Mostra tutti i prodotti</a>
                                @else
                                    <a class="dropdown-item" href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS'), ['filters' => '?showTerminateProducts=1']) }}">Mostra prodotti fuori stock</a>
                            @endif

                            <div class="dropdown-divider"></div>
                            @if(hasRole(Auth::id(), 'EXPORTER') > 0)
                                <a class="dropdown-item" href="{{ route(getRoute(Auth::id(), 'PRODUCT_EXPORT_EXCEL')) }}">Esportazione completa (con attributi)</a>
                                    <a class="dropdown-item" href="{{ route(getRoute(Auth::id(), 'PRODUCT_EXPORT_EXCEL')) }}">Esportazione parziale</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Numero CEAP</th>
                        <th>Numero C&C</th>
                        <th>Numero interno</th>
                        <th>Nome</th>
                        <th>Stato</th>
                        <th class="bg-secondary">Scuola</th>
                        <th class="bg-secondary">Quantità</th>
                        @if($showLess == 1)
                            <th class="bg-secondary">Quantità minima</th>
                        @endif
                        <th class="bg-secondary">Unità di misura</th>
                        <th style="width: 16%">Azioni</th>
                    </tr>

                    @isset($products)
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->product_num_ceap }}</td>
                                <td id="ccTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'C&C_NUM', $('#ccTd-{{ $product->id }}'))</script></td>
                                <td>{{ $product->product_num_intern }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ (($product->product_end == getSettings('DEFAULT_DATE_END')) || $product->product_end == null) ? "Attivo" : "Fuori stock" }}</td>
                                <td id="unityRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'UNITY', $('#unityRefTd-{{ $product->id }}'))</script></td>
                                <td id="qtyRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'QTY', $('#qtyRefTd-{{ $product->id }}'))</script></td>
                                @if($showLess == 1)
                                    <td id="minWarningRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'MIN_QTY', $('#minWarningRefTd-{{ $product->id }}'))</script></td>
                                @endif
                                <td id="unitRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'UNIT', $('#unitRefTd-{{ $product->id }}'))</script></td>
                                <td>
                                    <button class="btn btn-warning">
                                        <i class="fas fa-edit"></i> <a href="{{ route(getRoute(Auth::id(), 'UPDATE_PRODUCTS'), ['product_id' => $product->id]) }}" style="text-decoration:none; color: white;">Modifica</a>
                                    </button>
                                    <button class="btn btn-danger" onClick="deleteProduct({{ $product->id }})">
                                        <i class="fas fa-trash"></i>Elimina</a>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </table>
            </div>

            <div class="col-md-12">
                <div class="pagination justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection


@section('js')
    @parent

    <script>
        function deleteProduct(product_id) {
            let apiUrl = '/api/deleteProduct';

            $.ajax({
                url: apiUrl,
                type: 'POST',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    'product_id': product_id
                },
                success: function (data) {
                    if(data['message']==='deleted') {
                        location.reload()
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Errore API:', status, error);
                }
            });
        }
    </script>
@endsection
