@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Storico attributo: @isset($attributeName)<strong>{{ $attributeName->attribute_name }}</strong>@endisset</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Elenco prodotti</a></li>
                        <li class="breadcrumb-item active"><a href="{{ URL::previous() }}">Modifica</a></li>
                        <li class="breadcrumb-item active">Visualizza storico</li>
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
                <button class="btn btn-primary pull-left"><a style="text-decoration: none; color: white;" href="{{ URl::previous() }}">Indietro</a></button>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Valore</th>
                            <th scope="col">Data di INIZIO validità</th>
                            <th scope="col">Data di FINE validità</th>
                            <th scope="col">Modificato da...</th>
                            <th scope="col">Modificato il...</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($attributeDetails)
                            @foreach($attributeDetails as $attributeDetail)
                                <tr>
                                    <td>{{ $attributeDetail->attribute_value }}</td>
                                    <td>{{ formatDateTime($attributeDetail->attribute_date_start) }}</td>
                                    <td>{{ formatDateTime($attributeDetail->attribute_date_end) }}</td>
                                    <td>{{ getUserById($attributeDetail->user_id) }}</td>
                                    <td>{{ formatDateTime($attributeDetail->updated_at) }}</td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
