@extends('layouts.app')

@section('body')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Reporting</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS')) }}">{{ getUnityName(getUserActualUnity(Auth::id())) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Generazione dei report
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="title">
                                        <h4 class="text-blue h4">Selezionare l'unità</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pd-20 card-box mb-30">
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
                        <div class="card-box mb-30">
                            <div class="pd-20">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="title">
                                            <h4 class="text-blue h4">Popolazione di dati globale</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pd-20 card-box mb-30">
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

                    @if(isset($reports) && isset($populations))
                        <div class="card-box mb-30">
                            <div class="pd-20">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="title">
                                            <h4 class="text-blue h4">Selezionare il modello di dati</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pd-20 card-box mb-30">
                                <table class="table">
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Aggiornato il</th>
                                    </tr>

                                    @foreach($reports as $report)
                                        <tr>
                                            <td>
                                                <a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS'), ['unity_id' => $parameters['unity_id'], 'population_id' => $parameters['population_id'], 'report_mod_id' => $report->id]) }}"><i class="fas fa-solid fa-check"></i></a>
                                            </td>
                                            <td>{{ $report->report_name }}</td>
                                            <td>{{ formatDateTime($report->updated_at) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    @if(isset($reportColumns))
                        <div class="card-box mb-30">
                            <div class="pd-20">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="title">
                                            <h4 class="text-blue h4">Anteprima dell'esportazione</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pd-20 card-box mb-30">
                                <table class="data-table table stripe hover nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="table-plus datatable-nosort" style="width: 10px">#</th>
                                        @foreach($reportColumns as $column)
                                            <th scope="col">{{ $column->column_name }}</th>
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @isset($reportRow)
                                        @for($i = 0; $i < sizeof($reportRow); $i++)
                                            <tr>
                                                <td>{{ $reportRow[$i]->id }}</td>
                                                @foreach($reportColumns as $column)
                                                    <td>{{ $columnsValue($column->command_code, $column->column_signature, ['product_id' => $reportRow[$i]['id']]) }}</td>
                                                @endforeach
                                            </tr>
                                        @endfor
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent

    <script>
        $(function () {
            $("#previewTable").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf"]
            }).buttons().container().appendTo('#previewCard .col-md-6:eq(0)');
        });
    </script>
@endsection
