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
                            <td></td>
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

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));

            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });

            popoverList.forEach(function (popover) {
                popover.hide();
            });

            document.addEventListener('click', function (event) {
                popoverTriggerList.forEach(function (popoverTriggerEl) {
                    var isClickInside = popoverTriggerEl.contains(event.target) || (popoverTriggerEl.nextElementSibling && popoverTriggerEl.nextElementSibling.contains(event.target));
                    if (!isClickInside) {
                        var popover = bootstrap.Popover.getInstance(popoverTriggerEl);
                        if (popover) {
                            popover.hide();
                        }
                    }
                });
            });
        });

        function clearFilter(button) {
            var form = button.closest('.popover-content').querySelector('form');
            form.reset();
        }
    </script>
@endsection
