@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creazione modello di reporting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(getRoute(Auth::id(), 'ANNUAL_REPORTS')) }}">Report</a></li>
                        <li class="breadcrumb-item active">Creazione modello</li>
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
                @if(Session::has('messageFormModel'))
                    <div class="alert alert-success">
                        {{ Session::get('messageFormModel') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Informazioni sul modello</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route(getRoute(Auth::id(), 'STORE_REPORT_MODEL')) }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="report_name">Nome del report (*)</label>
                                            <input type="text" class="form-control" name="report_name" id="report_name" @isset($reportDetails->report_name) value="{{ $reportDetails->report_name }}" @endisset />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="report_description">Breve descrizione (*)</label>
                                            <input type="text" class="form-control" name="report_description" id="report_description" @isset($reportDetails->report_description) value="{{ $reportDetails->report_description }}" @endisset />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(hasRole(Auth::id(), 'ADMIN') > 0)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="user_id">Utente proprietario: @isset($reportDetails->user_id) <span style="color: red">{{ getUserById($reportDetails->user_id) }}</span>@endisset </label>
                                                <select class="form-control" id="user_id" name="user_id">
                                                    <option value="">Seleziona un'utente...</option>
                                                    @isset($users)
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->unity_id }}">{{ $user->username }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="unity_id">Disponibile sulla scuola: @isset($reportDetails->unity_id) <span style="color: red">{{ getUnityName($reportDetails->unity_id) }}</span>@endisset </label>
                                                <select class="form-control" id="unity_id" name="unity_id">
                                                    <option value="">Seleziona una scuola...</option>
                                                    @isset($unities)
                                                        @foreach($unities as $unity)
                                                            <option value="{{ $unity->unity_id }}">{{ $unity->unity_name }} ({{ $unity->unity_code }})</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Crea modello</button>
                            </div>
                        </form>
                        <br>

                        @isset($reportDetails->id)
                            <div class="container box">
                                @if(Session::has('messageFormColumn'))
                                    <div class="alert alert-success">
                                        {{ Session::get('messageFormColumn') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="box-header">
                                    <h3 class="box-title">Creazione delle colonne</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table">
                                        <tr>
                                            <th scope="col" style="width:10px">#</th>
                                            <th scope="col">Nome variabile</th>
                                            @if(hasRole(Auth::id(), 'ADMIN') > 0)
                                                <th scope="col">Argomenti</th>
                                                <th scope="col">Opzioni</th>
                                            @endif
                                            <th scope="col">Azioni</th>
                                        </tr>

                                        <tr id="insertingRow">
                                            <form method="post" action="{{ route(getRoute(Auth::id(), 'STORE_REPORT_MODEL_COLUMN')) }}">
                                                @csrf
                                                <input type="hidden" name="command_code" id="command-code" />
                                                <input type="hidden" name="report_ref_id" id="report_ref_id" value="{{ $reportDetails->id }}" />

                                                <td></td>
                                                <td>


                                                    <div class="form-group has-feedback @error('command_name') has-error @enderror">
                                                        <input type="text" id="live-search" name="command_name" class="form-control" placeholder="Ricerca variabile" autofocus>
                                                        <table class="table table-hover" id="search-results"></table>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="form-group has-feedback @error('command_signature') has-error @enderror">
                                                        <input @if(!hasRole(Auth::id(), 'ADMIN') > 0) readonly @endif type="text" id="var-arguments" name="command_signature" class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group has-feedback @error('command_options') has-error @enderror">
                                                        <input @if(!hasRole(Auth::id(), 'ADMIN') > 0) readonly @endif type="text" id="var-options" name="command_options" class="form-control">
                                                    </div>
                                                </td>

                                                <td>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-plus"></i> Aggiungi
                                                    </button>
                                                </td>
                                            </form>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        function detectArgumentsVariable(command) {
            const arguments = [];
            const regex = /\{(.*?)\}/g;
            let displayArgs = ""

            let match;

            while ((match = regex.exec(command)) !== null) {
                const argumentName = match[1];
                const isOptional = argumentName.endsWith('?');
                const cleanArgumentName = argumentName.replace('?', '');

                arguments.push({ name: cleanArgumentName, isOptional });
            }

            for(let i = 0; i < arguments.length; i++) {
                displayArgs = displayArgs + ' ' + arguments[i]['name'] + '= ,'
            }

            return displayArgs;
        }

        $(document).ready(function() {
            $('#live-search').keyup(function() {
                var query = $(this).val();

                $.ajax({
                    url: '{{ route(getRoute(Auth::id(), 'SEARCH_VARIABLE')) }}',
                    method: 'GET',
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data: { query: query },
                    success: function(data) {
                        $('#search-results').empty();

                        $.each(data, function(index, item) {
                            $('#search-results').append(`<tr><td><i id="commandNameOption-${index}" class="fas fa-solid fa-check"></i></td><td>` + item.command_name + '</td></tr>');

                            $(`#commandNameOption-${index}`).click(() => {
                                let varNameField = $('#live-search')
                                let argVarField = $('#var-arguments')
                                let optionFields = $('#var-options')
                                let varCodeField = $('#command-code')

                                let commandCode = $(this)[0]['command_code'];
                                let commandName = $(this)[0]['command_name'];
                                let commandSignature = $(this)[0]['command_signature']
                                let commandOptions = $(this)[0]['command_options']
                                let arguments = detectArgumentsVariable(commandSignature)

                                varCodeField.val(commandCode)
                                varNameField.val(commandName);
                                argVarField.val(arguments);
                                optionFields.val(commandOptions);

                                $('#search-results').empty();
                            });
                        });
                    }
                });
            });
        });
    </script>
@endsection
