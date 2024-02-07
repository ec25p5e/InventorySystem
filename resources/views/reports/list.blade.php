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

@endsection
