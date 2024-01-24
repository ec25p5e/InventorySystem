<!-- resources/views/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        <h1>Elenco Prodotti</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        <a href="#" data-bs-toggle="popover" title="Filtra per numero CEAP" data-bs-placement="top">
                            Numero CEAP <span class="material-symbols-outlined">
                                tune
                            </span>
                        </a>
                        <div class="popover-content">
                            <form action="{{ route('products.index') }}" method="get">
                                <input name="filter__product_num_ceap" value="{{ $filters[0] }}" type="text" class="form-control" placeholder="Filtra">
                                <button class="btn btn-primary btn-sm mt-2">Applica</button>
                                <button class="btn btn-secondary btn-sm mt-2" onclick="clearFilter(this)">Svuota</button>
                            </form>
                        </div>
                    </th>

                    <th>
                        <a href="#" data-bs-toggle="popover" title="Filtra per numero interno" data-bs-placement="top">
                            Numero interno  <span class="material-symbols-outlined">
                                tune
                            </span>
                        </a>
                        <div class="popover-content">
                            <form action="{{ route('products.index') }}" method="get">
                                <input name="filter__product_num_intern" value="{{ $filters[1] }}" type="text" class="form-control" placeholder="Filtra">
                                <button class="btn btn-primary btn-sm mt-2">Applica</button>
                                <button class="btn btn-secondary btn-sm mt-2" onclick="clearFilter(this)">Svuota</button>
                            </form>
                        </div>
                    </th>

                    <th>
                        <a href="#" data-bs-toggle="popover" title="Filtra per nome" data-bs-placement="top">
                            Nome  <span class="material-symbols-outlined">
                                tune
                            </span>
                        </a>
                        <div class="popover-content">
                            <form action="{{ route('products.index') }}" method="get">
                                <input name="filter__product_name" value="{{ $filters[2] }}" type="text" class="form-control" placeholder="Filtra">
                                <button class="btn btn-primary btn-sm mt-2">Applica</button>
                                <button class="btn btn-secondary btn-sm mt-2" onclick="clearFilter(this)">Svuota</button>
                            </form>
                        </div>
                    </th>

                    <th>
                        <a href="#" data-bs-toggle="popover" title="Filtra per stato" data-bs-placement="top">
                            Stato
                        </a>
                    </th>

                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->product_image }}</td>
                        <td>{{ $product->product_num_ceap }}</td>
                        <td>{{ $product->product_num_intern }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ ($product->product_end == null) ? "Attivo" : "Inutilizzato" }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

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
