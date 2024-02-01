@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creazione formulario (form)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Elenco formulari</a></li>
                        <li class="breadcrumb-item active">Creazione</li>
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
                <h3 class="box-title">Form per la creazione del formulario</h3>
            </div>
            <div class="box-body">
                <form action="" method="post" name="form-product">
                    @csrf

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="liveSearch">Codice univoco formulario</label>
                                    <input type="text" class="form-control" name="form_code" id="form_code" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="liveSearch">Titolo del formulario</label>
                                    <input type="text" class="form-control" name="form_name" id="form_name" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="liveSearch">Sotto-titolo formulario</label>
                                    <input type="text" class="form-control" name="form_description" id="form_description" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="liveSearch">Data di inizio validità</label>
                                    <input type="text" class="form-control" name="form_start" id="liveSearch product_num_ceap" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
