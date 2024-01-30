@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creazione prodotto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(getRoute(Auth::id, 'LIST_OF_PRODUCTS')) }}">Elenco prodotti</a></li>
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
                    <h4 class="modal-title" id="myModalLabel">Duplica prodotto: @isset($productDetails) {{ $productDetails->product_name }} @endisset</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('products.duplicate') }}">
                        <div class="form-group">
                            <label for="unity_ref" class="form-label">Scuola di riferimento per il nuovo prodotto</label>
                            <select class="form-control" id="unity_ref" name="unity_ref">
                                @isset($unities)
                                    @foreach($unities as $unity)
                                        <option value="{{ $unity->id }}">{{ $unity->unity_name }} ({{ $unity->unity_code }})</option>
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

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Form per la creazione del prodotto</h3>
                <h5 style="color: red;">Dopo il salvataggio è possibile inserire degli attributi. I campi contrassegnati con * sono obbligatori. Data di inizio e fine non sono da modificare per la v1</h5>
                @isset($productDetails->id)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#duplicateProductModal">Duplica prodotto</button>
                @endisset
            </div>
            <div class="box-body">
                <form action="{{ route('products.store') }}" method="post" name="form-product">
                    @csrf

                    <input name="productIdHidden" type="hidden" @isset($productDetails->id) value="{{ $productDetails->id }}" @endisset />

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="liveSearch">Numero CEAP (*)</label>
                                    <input type="text" class="form-control" name="product_num_ceap" id="liveSearch product_num_ceap" @isset($productDetails->product_num_ceap) value="{{ $productDetails->product_num_ceap }}" @endisset  />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="product_num_intern" class="form-label">Numero interno (*):</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" @isset($productDetails->product_num_intern) value="{{ $productDetails->product_num_intern }}" @endisset name="product_num_intern">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="product_name" class="form-label">Nome (*):</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" @isset($productDetails->product_name) value="{{ $productDetails->product_name }}" @endisset name="product_name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_start" class="form-label">Data di INIZIO validità:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" @isset($productDetails->product_start) value="{{ formatDate($productDetails->product_start) }}" @else value="{{ formatDate(now()) }}" @endisset name="product_start">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="product_end" class="form-label">Data di FINE validità:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" @isset($productDetails->product_end) value="{{ formatDate($productDetails->product_end) }}" @else value="3001-01-01" @endisset name="product_end">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 ml-3">
                            <button type="submit" class="btn btn-primary">Invia dati</button>
                        </div>
                    </div>
                </form>

                <div class="container box">
                    <div class="box-header">
                        <h3 class="box-title">Tabella degli attributi</h3>

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success-product-attribute') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="box-body">
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
                                    <form action="{{ route('products.attribute.store') }}" method="POST" class="form-control" name="form-product-attributes">
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
                                            <td>{{$productsAttribute->attribute_name}}</td>
                                            <td>{{$productsAttribute->attribute_value}}</td>
                                            <td>{{ ($productsAttribute->attribute_hidden == 1) ? 'SI' : 'NO' }}</td>
                                            <td>{{ formatDateTime($productsAttribute->updated_at) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger" onClick="deleteProductAttribute({{$productsAttribute->id}}, {{ $productDetails->id }})">
                                                    <i class="fas fa-trash"></i> Elimina
                                                </button>
                                                <button type="button" class="btn btn-info">
                                                    <i class="fas fa-info"></i> <a href="{{ route('products.update.showHistory', ['product_id' => $productDetails->id, 'product_attr_id' => $productsAttribute->id]) }}" style="text-decoration:none; color: white;">Visualizza storico</a>
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
    </section>
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

        function checkIfCeapExists(queryString) {
            console.log(queryString)
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

