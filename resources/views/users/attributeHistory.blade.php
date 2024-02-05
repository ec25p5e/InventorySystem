@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gestione utenti</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ URL::previous() }}">{{ $user->username }}</a></li>
                        <li class="breadcrumb-item active">Storico degli attributi</li>
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

            </div>

            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th scope="col">Valore</th>
                        <th scope="col">Data di INIZIO validità</th>
                        <th scope="col">Data di FINE validità</th>
                        <th scope="col">Modificato da...</th>
                        <th scope="col">Modificato il...</th>
                    </tr>

                    @isset($histories)
                        @foreach($histories as $history)
                            <tr>
                                <td>{{ $history->attribute_value }}</td>
                                <td>{{ $history->attribute_date_start }}</td>
                                <td>{{ $history->attribute_date_end }}</td>
                            </tr>
                        @endforeach
                    @endisset
                </table>
            </div>
        </div>
    </section>
@endsection
