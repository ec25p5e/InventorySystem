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
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Elenco prodotti</a></li>
                        <li class="breadcrumb-item active">Creazione</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Form per la creazione del prodotto</h3>
                <h5 style="color: red;">Compilare i campi con *</h5>
            </div>
            <div class="box-body">
                <form action="{{ route('products.store') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_num_ceap" class="form-label">Numero CEAP (*):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    <input type="text" class="form-control" name="product_num_ceap">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="product_num_intern" class="form-label">Numero interno (*):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input type="text" class="form-control" name="product_num_intern">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="product_name" class="form-label">Nome (*):</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="product_name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_start" class="form-label">Data di INIZIO validità:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control" name="product_start">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="product_end" class="form-label">Data di FINE validità:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control" name="product_end">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container mt-5 box">
                        <div class="box-header">
                            <h3 class="box-title">Tabella degli attributi</h3>
                        </div>
                        <div class="box-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Codice attributo</th>
                                        <th scope="col">Nome da mostrare</th>
                                        <th scope="col">Valore</th>
                                        <th scope="col">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <form action="" method="post" class="form-control">
                                            @csrf

                                            <td>
                                                <div class="form-group has-feedback @error('attribute_code') has-error @enderror">
                                                    <input type="text" name="attribute_code" class="form-control" placeholder="Codice identificativo" required value="{{ old('attribute_code') }}" autofocus>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <div class="form-group has-feedback @error('attribute_value') has-error @enderror">
                                                    <input type="text" name="attribute_value" class="form-control" placeholder="Immettere un valore per l'attributo" required value="{{ old('attribute_value') }}" autofocus>
                                                </div>
                                            </td>
                                            <td>
                                                <!-- Pulsanti vari -->
                                            </td>
                                        </form>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Aggiungi</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="{{ asset('/js/create_product.js.js') }}"></script>
@endsection
