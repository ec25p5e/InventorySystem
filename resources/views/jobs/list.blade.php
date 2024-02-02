@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gestione dei cron job</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Menu admin</a></li>
                        <li class="breadcrumb-item active">Elenco cron</li>
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
                <h3 class="box-title">Elenco dei cron</h3>

                <button class="btn btn-primary mr-3 pull-right">
                    <a style="text-decoration: none; color: white;" href="{{ route(getRoute(Auth::id(), 'CREATE_JOB')) }}">Nuovo cron job</a>
                </button>
            </div>

            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nome</th>
                        <th>Comando</th>
                        <th>Pianificazione</th>
                        <th>Stato</th>
                        <th style="width: 16%">Azioni</th>
                    </tr>

                    @isset($jobs)
                        @foreach($jobs as $job)
                            <tr>
                                <td>{{ $job->id }}</td>
                                <td>{{ $job->name }}</td>
                                <td>{{ $job->command }}</td>
                                <td>{{ $job->schedule }}</td>
                                <td>{{ ($job->is_active) > 0 ? "Attivo" : "Inattivo" }}</td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </table>
            </div>
        </div>
    </section>
@endsection
