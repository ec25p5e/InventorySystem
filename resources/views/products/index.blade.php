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
                        <th style="width: 40px">Azioni</th>
                    </tr>

                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product_image }}</td>
                            <td>{{ $product->product_num_ceap }}</td>
                            <td>{{ $product->product_num_intern }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ ($product->product_end == null) ? "Attivo" : "Inutilizzato" }}</td>
                            <td>
                                <button class="btn btn-warning">
                                    <i class="fas fa-edit"></i> <a href="{{ route('products.update', ['product_id' => $product->id]) }}" style="text-decoration:none; color: white;">Modifica</a>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
