@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <form action="{{ route('products.store') }}" method="post">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="product_num_ceap" class="form-label">Numero CEAP <i class="fas fa-hashtag"></i>:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                            <input type="text" class="form-control" name="product_num_ceap">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="product_num_intern" class="form-label">Numero interno <i class="fas fa-building"></i>:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input type="text" class="form-control" name="product_num_intern">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="product_name" class="form-label">Nome <i class="fas fa-user"></i>:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="product_name">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="product_start" class="form-label">Data di INIZIO validità <i class="fas fa-calendar-alt"></i>:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input type="text" class="form-control" name="product_start">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="product_end" class="form-label">Data di FINE validità <i class="fas fa-calendar-alt"></i>:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input type="text" class="form-control" name="product_end">
                        </div>
                    </div>
                </div>
            </div>

            <!-- <table class="table">
                <thead>
                <tr>
                    <th scope="col">Colonna 1</th>
                    <th scope="col">Colonna 2</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Dato 1</td>
                    <td>Dato 2</td>
                </tr>
                </tbody>
            </table> -->

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Aggiungi</button>
            </div>
        </form>
    </div>
@endsection
