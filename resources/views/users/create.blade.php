@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creazione utente completa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Elenco utenti</a></li>
                        <li class="breadcrumb-item active">Creazione completa utente</li>
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
                <h3 class="box-title">Form per la creazione di un nuovo utente + assegnazione della chiave/badge</h3>
            </div>
            <div class="box-body">
                <form action="" method="post" name="form-product">
                    @csrf
                </form>
            </div>
        </div>
    </section>
@endsection
