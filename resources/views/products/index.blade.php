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
                                    Elenco economato
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="dropdown">
                            <a
                                class="btn btn-primary dropdown-toggle"
                                href="#"
                                role="button"
                                data-toggle="dropdown"
                            >
                                Opzioni
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">
                        @if($showLess == 1)
                            Prodotti in esaurimento
                        @elseif($showTerminateProducts == 1)
                            Prodotti fuori stock
                        @else
                            Tutti gli articoli dell'economato
                        @endif
                    </h4>
                </div>

                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">#</th>
                            <th>Numero CEAP</th>
                            <th>Numero C&C</th>
                            <th>Numero interno</th>
                            <th>Nome</th>
                            <th>Stato</th>
                            <th>Scuola</th>
                            <th>Quantità</th>
                            @if($showLess == 1)
                                <th >Quantità minima</th>
                            @endif
                            <th>Unità di misura</th>
                            <th class="datatable-nosort">Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
