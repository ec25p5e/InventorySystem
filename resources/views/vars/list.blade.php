@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Variabili</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Gestione di sistema</a></li>
                        <li class="breadcrumb-item active">Elenco delle variabili</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-danger">
                            <i class="fas fa-trash"></i> <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_VARS')) }}" style="text-decoration:none;color:white"> Ripristina vista</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="card-title">Selezionare l'unità</h3>
                    </div>
                    <div class="box-body">
                        <div class="treeview js-treeview">
                            <ul>
                                @isset($unities)
                                    @foreach($unities as $unity)
                                        @include('partials.treeChild', ['unity' => $unity, 'route' => 'LIST_OF_VARS'])
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

                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped" id="dataTablesStandard">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Codice univoco</th>
                                <th>Nome variabile</th>
                                <th>Firma</th>
                                <th>Opzioni</th>
                                <th>Unità di riferimento</th>
                                <th>Utente di riferimento</th>
                                <th>Data di creazione</th>
                                <th>Data di modifica</th>
                                <th style="width: 16%">Azioni</th>
                            </tr>
                            </thead>

                            <tbody>
                               @isset($variables)
                                   @foreach($variables as $var)
                                       <tr>
                                           <td>{{ $var->id }}</td>
                                           <td>{{ $var->command_code }}</td>
                                           <td>{{ $var->command_name }}</td>
                                           <td>{{ $var->command_signature }}</td>
                                           <td>{{ $var->command_options }}</td>
                                           <td>{{ getUnityCode($var->command_unity_ref) }}</td>
                                           <td>{{ getUserById($var->command_user_ref) }}</td>
                                           <td>{{ formatDateTime($var->created_at) }}</td>
                                           <td>{{ formatDateTime($var->updated_at) }}</td>
                                           <td>
                                               <button class="btn btn-warning">
                                                   <i class="fas fa-edit"></i> <a href="{{ route(getRoute(Auth::id(), 'UPDATE_VARIABLE'), ['variable_id' => $var->id]) }}" style="text-decoration:none; color: white;">Modifica</a>
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
        $(function () {
            $("#dataTablesStandard").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            });
        });
    </script>
@endsection
