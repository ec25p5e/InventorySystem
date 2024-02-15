@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creazione articolo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS')) }}">Elenco prodotti</a></li>
                        <li class="breadcrumb-item active">Creazione</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <div class="modal fade" id="duplicateProductModal" tabindex="-1" role="dialog" aria-labelledby="Duplica Prodotto" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Duplica articolo: @isset($productDetails) {{ $productDetails->product_name }} @endisset</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route(getRoute(Auth::id(), 'DUPLICATE_PRODUCT')) }}">
                        @csrf

                        <div class="form-group">
                            <label for="unity_ref" class="form-label">Scuola di riferimento per il nuovo articolo</label>
                            <select class="form-control" id="unity_ref" name="unity_ref">
                                @isset($unities)
                                    @foreach($unities as $unity)
                                        <option value="{{ $unity->unity_id }}">{{ $unity->unity_name }} ({{ $unity->unity_code }})</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success align-right">Copia prodotto</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

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
                                    Creazione/modifica articolo
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-md-6 col-sm-12 text-right">
                        <a
                            class="btn btn-primary"
                            href="#"
                            role="button"
                        >
                            Duplica articolo
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">
                        Formulario creazione/modifica prodotto
                    </h4>
                </div>

                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="pd-20 card-box mb-30">
                    <form action="{{ route(getRoute(Auth::id(), 'STORE_PRODUCT')) }}" method="post" name="form-product">
                        @csrf

                        <input name="productIdHidden" type="hidden" @isset($productDetails->id) value="{{ $productDetails->id }}" @endisset />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="liveSearch">Numero CEAP</label>
                                    <div class="form-group @error('product_num_ceap') has-error @enderror">
                                        <input type="text" class="form-control" name="product_num_ceap" id="liveSearch product_num_ceap" @isset($productDetails->product_num_ceap) value="{{ $productDetails->product_num_ceap }}" @endisset  />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="product_num_intern" class="form-label">Numero interno:</label>
                                    <div class="input-group @error('product_num_intern') has-error @enderror">
                                        <input type="text" class="form-control" @isset($productDetails->product_num_intern) value="{{ $productDetails->product_num_intern }}" @endisset name="product_num_intern">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Nome (*):</label>
                                    <div class="input-group has-feedback @error('product_name') has-error @enderror">
                                        <input type="text" class="form-control" @isset($productDetails->product_name) value="{{ $productDetails->product_name }}" @endisset name="product_name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_start" class="form-label">Data di INIZIO validità:</label>
                                    <div class="input-group @error('product_start') has-error @enderror ">
                                        <input type="date" class="form-control" @isset($productDetails->product_start) value="{{ formatDate($productDetails->product_start) }}" @else value="{{ formatDate(now()) }}" @endisset name="product_start">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="product_end" class="form-label">Data di FINE validità:</label>
                                    <div class="input-group @error('product_end') has-error @enderror ">
                                        <input type="date" class="form-control" @isset($productDetails->product_end) value="{{ formatDate($productDetails->product_end) }}" @else value="3001-01-01" @endisset name="product_end">
                                    </div>
                                </div>

                                @if(!isset($productDetails))
                                    <div class="mb-3">
                                        <label for="unity_ref" class="form-label">Unità scolastica (*):</label>
                                        <select class="form-control" id="unity_ref" name="unity_ref">
                                            @isset($unities)
                                                @foreach($unities as $unity)
                                                    <option value="{{ $unity->unity_id }}">{{ $unity->unity_name }} ({{ $unity->unity_code }})</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3 ml-3">
                                <button type="submit" class="btn btn-primary">Invia dati</button>
                            </div>
                        </div>
                    </form>

                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <h4 class="text-blue h4">
                                Tabella degli attributi
                            </h4>
                        </div>

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success-product-attribute') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="pd-20 card-box mb-30">
                            <table class="table">
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
                                <tr id="insertingRow">
                                    <form action="{{ route(getRoute(Auth::id(), 'STORE_PRODUCT_ATTR')) }}" method="POST" class="form-control" name="form-product-attributes">
                                        @csrf
                                        <input type="hidden" name="productId" @isset($product_id) value="{{ $product_id }}" @endisset />

                                        <td>
                                            <div class="form-group has-feedback @error('attribute_code') has-error @enderror">
                                                <select class="form-control" id="attribute_code" name="attribute_code">
                                                    @foreach($attributeDefinitions as $def)
                                                        <option value="{{ $def->id }}">{{ $def->def_name }} ({{ $def->def_code }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group has-feedback @error('attribute_value') has-error @enderror">
                                                <input type="text" name="attribute_value" class="form-control" placeholder="Immettere un valore per l'attributo" value="{{ old('attribute_value') }}" autofocus>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group has-feedback @error('attribute_hidden') has-error @enderror">
                                                <select class="form-control" id="attribute_hidden" name="attribute_hidden">
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-plus"></i> Aggiungi
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                                @isset($productAttributes)
                                    @foreach($productAttributes as $productsAttribute)
                                        <tr>
                                            <td>{{ getAttributeName($productsAttribute->attribute_code) }}</td>
                                            <td>@if($productsAttribute->attribute_code == getAttributeIdByCode('UNITY')) {{ getUnityCode($productsAttribute->attribute_value) }} @else {{ $productsAttribute->attribute_value}} @endif</td>
                                            <td>{{ ($productsAttribute->attribute_hidden == 1) ? 'SI' : 'NO' }}</td>
                                            <td>{{ formatDateTime($productsAttribute->updated_at) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger" onClick="deleteProductAttribute({{$productsAttribute->id}}, {{ $productDetails->id }})">
                                                    <i class="fas fa-trash"></i> Elimina
                                                </button>
                                                <button type="button" class="btn btn-info">
                                                    <i class="fas fa-info"></i> <a href="{{ route(getRoute(Auth::id(), 'SHOW_PRODUCT_ATTR_HISTORY'), ['product_id' => $productDetails->id, 'product_attr_id' => $productsAttribute->id]) }}" style="text-decoration:none; color: white;">Visualizza storico</a>
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
        </div>
    </div>
@endsection

@section('js')
    @parent

    <script>
        setTimeout(function() {
            $('#success-alert').alert('close');
        }, 5000);

        $(document).ready(function() {
            $('#liveSearch').on('change', function() {
                checkIfCeapExists($(this).val());
            });
        });

        function duplicateProduct(product_id) {
            let apiUrl = '/api/productDuplicate';

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
                    alert(data['message']);
                },
                error: function (xhr, status, error) {
                    console.error('Errore API:', status, error);
                }
            });
        }

        function deleteProductAttribute(productAttrId, productId) {
            let apiUrl = '/api/deleteProductAttribute';

            $.ajax({
                url: apiUrl,
                type: 'POST',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    'product_attribute_id': productAttrId,
                    'product_id': productId,
                },
                success: function (data) {
                    if(data['message'] === 'Eliminato con successo!')
                        location.reload()
                        alert('Eliminato con successo')
                },
                error: function (xhr, status, error) {
                    console.error('Errore API:', status, error);
                }
            });
        }
    </script>
@endsection

