@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creazione variabili</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Elenco delle variabili</a></li>
                        <li class="breadcrumb-item active">Creazione</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('start_js')
    @parent

    <script>
        require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.24.0/min/vs' }});
        require(['vs/editor/editor.main'], function() {
            // Inizializzazione dell'editor
            monaco.editor.create(document.getElementById('monaco_editor_textarea'), {
                value: `<?php echo htmlentities($varCode); ?>`,
                language: 'php'
            });
        });
    </script>
@endsection


@section('body')
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Form per la creazione della variabile</h3>
                <h5 style="color: red;">I campi contrassegnati con * sono obbligatori.</h5>
            </div>
            <div class="box-body">
                <form action="{{ route(getRoute(Auth::id(), 'STORE_VARIABLE')) }}" method="post" name="form-product">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_code">Codice univoco</label>
                                    <input type="text" class="form-control" name="command_code" id="command_code"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_name">Nome (utilizzato nel nome delle colonne)</label>
                                    <input type="text" class="form-control" name="command_name" id="command_name"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_code">Breve descrizione della variabile</label>
                                    <input type="text" class="form-control" name="command_code" id="command_code"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_signature">Firma (signature)</label>
                                    <input type="text" class="form-control" name="command_signature" id="command_signature"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_options">Opzioni</label>
                                    <input type="text" class="form-control" name="command_options" id="command_options"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="monaco-editor-container" style="height: 250px; border: 1px solid rgb(238, 238, 238);"></div>
                            <textarea name="custom_script" id="monaco_editor_textarea" style="display: none; white-space: pre-line"></textarea>
                        </div>
                    </div>
                    <br>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Crea variabile</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection