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
                        <li class="breadcrumb-item active">Creazione nuovo cron</li>
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
                <h3 class="box-title">Form creazione cron</h3>
            </div>

            <div class="box-body">
                <form action="{{ route(getRoute(Auth::id(), 'STORE_CRON_JOB')) }}" method="post" name="form-product">
                    @csrf


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="cron_name">Nome</label>
                                    <input type="text" class="form-control" name="name" id="name" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="cron_command">Comando</label>
                                    <input type="text" class="form-control" name="command" id="command" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="cron_schedule">Pianificazione</label>
                                    <input type="text" class="form-control" name="schedule" id="schedule" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mt-6">
                                <div class="form-group">
                                    <select class="form-control" id="is_active" name="is_active">
                                        <option selected value="1">Attivo</option>
                                        <option selected value="0">Inattivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Crea cron job</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
