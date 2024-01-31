@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="ineer">
                        <h3>150</h3>
                        <p>Prodotti</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-solid fa-product"></i>
                    </div>

                    <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS')) }}" class="small-box-footer">
                        Tutti i prodotti
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="ineer">
                        <h3>150</h3>
                        <p>Prodotti</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-solid fa-product"></i>
                    </div>

                    <a href="{{ route(getRoute(Auth::id(), 'LIST_OF_PRODUCTS')) }}" class="small-box-footer">
                        Tutti i prodotti
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
