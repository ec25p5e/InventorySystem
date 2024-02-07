@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Elenco dei percorsi del programma</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-itema active">Gestione del routing dell'app</li>
                        <li class="breadcrumb-item">Elenco dei percorsi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Selezionare le unità</h3>
                    </div>
                    <div class="box-body">
                        <div class="treeview js-treeview">
                            <ul>
                                @isset($unities)
                                    @foreach($unities as $unity)
                                        @include('partials.treeChild', ['unity' => $unity, 'route' => 'ROUTE_CONF'])
                                    @endforeach
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Elenco dei percorsi per unità</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Codice univoco</th>
                                <th>Ruolo</th>
                                <th>Unità</th>
                                <th>Nome laravel</th>
                                <th>URL</th>
                                <th>Metodo</th>
                                <th>Controller</th>
                                <th>Metodo del controller</th>
                                <th>Middleware</th>
                                <th style="width: 16%">Azioni</th>
                            </tr>

                            @isset($results)
                                @foreach($results as $result)

                                @endforeach
                            @endisset
                        </table>

                        <div class="pagination pagination-sm">
                            @isset($results)
                                @if ($results->currentPage() > 1)
                                    <a href="{{ $results->previousPageUrl() }}" class="page-link">Previous</a>
                                @endif

                                @for ($i = 1; $i <= $results->lastPage(); $i++)
                                    <a href="{{ $results->url($i) }}" class="page-link {{ $results->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                                @endfor

                                @if ($results->currentPage() < $results->lastPage())
                                    <a href="{{ $results->nextPageUrl() }}" class="page-link">Next</a>
                                @endif
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
