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

@section('body')
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Form per la creazione della variabile</h3>
                <h5 style="color: red;">I campi contrassegnati con * sono obbligatori.</h5>
            </div>
            <div class="box-body">
                <form id="storeVariableForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_code">Codice univoco</label>
                                    <input type="text" class="form-control" name="command_code" id="command_code" @isset($variableDetails->command_code) value="{{ $variableDetails->command_code }}" readonly @endisset/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_name">Nome (utilizzato nel nome delle colonne)</label>
                                    <input type="text" class="form-control" name="command_name" id="command_name" @isset($variableDetails->command_name) value="{{ $variableDetails->command_name }}" @endisset/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_code">Breve descrizione della variabile</label>
                                    <input type="text" class="form-control" name="command_description" id="command_description" @isset($variableDetails->command_description) value="{{ $variableDetails->command_description }}"  @endisset/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_signature">Firma (signature)</label>
                                    <input type="text" class="form-control" name="command_signature" id="command_signature" @isset($variableDetails->command_signature) value="{{ $variableDetails->command_signature }}"  @endisset/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="command_options">Opzioni</label>
                                    <input type="text" class="form-control" name="command_options" id="command_options" @isset($variableDetails->command_options) value="{{ $variableDetails->command_options }}" readonly @endisset/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="editor" name="editor" style="height: 500px"></div>
                        </div>
                    </div>
                    <br>

                    <div class="mb-3">
                        <button type="button" id="createVarSubmit" class="btn btn-primary">Crea variabile</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var editor = ace.edit("editor");

            $('#createVarSubmit').click(function () {
                let formData = {
                    'command_code': $('#command_code').val(),
                    'command_name' : $('#command_name').val(),
                    'command_description': $('#command_description').val(),
                    'command_signature': $('#command_signature').val(),
                    'command_options': $('#command_options').val(),
                    'editor': editor.getValue()
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route(getRoute(Auth::id(), 'STORE_VARIABLE')) }}',
                    data: formData,
                    dataType: 'json',
                    encode: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(data) {
                    console.log(data);
                })
                .fail(function(data) {
                    console.log('Errore nella richiesta AJAX: ' + data);
                });
            })
        })
    </script>
@endsection
