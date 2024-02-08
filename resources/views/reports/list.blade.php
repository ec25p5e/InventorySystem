@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Elenco dei report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS')) }}">Elenco dei report</a></li>
                        <li class="breadcrumb-item active">Elenco</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-danger">
                        <i class="fas fa-trash"></i> <a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS')) }}" style="text-decoration:none;color:white"> Ripristina vista</a>
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-save"></i> <a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS')) }}" style="text-decoration:none;color:white"> Esporta in Excel</a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Selezionare l'unità</h3>
                </div>
                <div class="card-body">
                    <div class="treeview js-treeview">
                        <ul>
                            @isset($unities)
                                @foreach($unities as $unity)
                                    @include('partials.treeChild', ['unity' => $unity, 'route' => 'ANNUAL_REPORTS'])
                                @endforeach
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>

            @isset($populations)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Popolazione di dati globale</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nome</th>
                                <th scope="col">Aggiornato il</th>
                            </tr>

                            @foreach($populations as $pop)
                                <tr>
                                    <td>
                                        <a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS'), ['unity_id' => $parameters['unity_id'], 'population_id' => $pop->id]) }}"><i class="fas fa-solid fa-check"></i></a>
                                    </td>
                                    <td>{{ $pop->population_name }}</td>
                                    <td>{{ formatDateTime($pop->updated_at) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endisset
        </div>

        <div class="col-md-9 col-md-offset-12">
            @if(isset($reports) && isset($populations))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Selezionare il modello di dati</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nome</th>
                                <th scope="col">Proprietario (persona)</th>
                                <th scope="col">Proprietario (scuola)</th>
                                <th scope="col">Aggiornato il</th>
                            </tr>

                            @foreach($reports as $report)
                                <tr>
                                    <td>
                                        <a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS'), ['unity_id' => $parameters['unity_id'], 'population_id' => $parameters['population_id'], 'report_mod_id' => $report->id]) }}"><i class="fas fa-solid fa-check"></i></a>
                                    </td>
                                    <td>{{ $report->report_name }}</td>
                                    <td>{{ getUserById($report->user_id) }}</td>
                                    <td>{{ getUnityCode($report->unity_id) }}</td>
                                    <td>{{ formatDateTime($report->updated_at) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif

            @if(isset($reportColumns))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Anteprima dell'esportazione</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th scope="col" style="width: 10px">#</th>
                                @foreach($reportColumns as $column)
                                    <th scope="col">{{ $column->column_name }}</th>
                                @endforeach
                            </tr>

                            @isset($reportRow)
                                @for($i = 0; $i < sizeof($reportRow); $i++)
                                    <tr>
                                        <td>{{ $reportRow[$i]->id }}</td>
                                        @foreach($reportColumns as $column)
                                            <td>{{ getUnityCode($columnsValue($column->command_code, $column->column_signature, ['product_id' => $reportRow[$i]['id']])) }}</td>
                                        @endforeach
                                    </tr>
                                @endfor
                            @endisset
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
