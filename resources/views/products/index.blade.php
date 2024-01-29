@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
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
            <div class="box-header">
                <h3 class="box-title">Elenco dei prodotti</h3>
                @if(hasRole())
                    <button class="btn btn-success pull-right ml-3" type="button" id="exportProductsToExcel"><a style="text-decoration: none; color: white;" href="{{ route('products.export_to_excel') }}">Esporta in Excel</a></button>
                @endif

                <button class="btn btn-primary pull-right"><a style="text-decoration: none; color: white;" href="{{ route('products.create') }}">Nuovo prodotto</a></button>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Numero CEAP</th>
                        <th>Numero interno</th>
                        <th>Nome</th>
                        <th>Stato</th>
                        <th class="bg-secondary">Scuola</th>
                        <th class="bg-secondary">Quantità</th>
                        <th class="bg-secondary">Unità di misura</th>
                        <th style="width: 16%">Azioni</th>
                    </tr>

                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_num_ceap }}</td>
                            <td>{{ $product->product_num_intern }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ ($product->product_end == getSettings('DEFAULT_DATE_END')) ? "Attivo" : "Inutilizzato" }}</td>
                            <td id="unityRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'UNITY', $('#unityRefTd-{{ $product->id }}'))</script></td>
                            <td id="qtyRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'QTY', $('#qtyRefTd-{{ $product->id }}'))</script></td>
                            <td id="unitRefTd-{{ $product->id }}"><script>loadUnityInformation({{ $product->id }}, 'product_attributes', 'UNIT', $('#unitRefTd-{{ $product->id }}'))</script></td>
                            <td>
                                <button class="btn btn-warning">
                                    <i class="fas fa-edit"></i> <a href="{{ route('products.update', ['product_id' => $product->id]) }}" style="text-decoration:none; color: white;">Modifica</a>
                                </button>
                                <button class="btn btn-danger" onClick="deleteProduct({{ $product->id }})">
                                    <i class="fas fa-trash"></i>Elimina</a>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-md-12">
                <div class="pagination justify-content-center">

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
