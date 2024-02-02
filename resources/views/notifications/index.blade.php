@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notifiche</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Elenco delle notifiche</li>
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
                <h3 class="box-title">Elenco delle notifiche</h3>
            </div>
            <div class="box-body">
                <div class="timeline timeline-inverse">
                    @isset($timelineDates)
                        @foreach($timelineDates as $date)
                            <div class="time-label">
                                <span class="bg-green">{{ $date->attribute_date }}</span>
                            </div>

                            @foreach($moveForDate($date->attribute_date) as $move)
                                <p></p>
                                <div>
                                    <i class="fas fa-envelope {{ ($move->attribute_log == "DECREMENT") ? "bg-danger" : "bg-info" }}"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="{{ ($move->attribute_log == "DECREMENT") ? "fas fa-solid fa-arrow-left" : "fas fa-solid fa-arrow-right" }}"></i> {{ formatDateTime($move->attribute_date_start) }}</span>
                                        <h3 class="timeline-header"><a href="#">{{ getUserById($move->user_id) }}</a> {{ ($move->attribute_log == "DECREMENT") ? " ha prelevato dal " : " ha aggiunto al" }} magazzino</h3>
                                        <div class="timeline-body">
                                            Sono
                                            {{ ($move->attribute_log == "DECREMENT") ? " stati sottratti " : " stati aggiunti " }}
                                            {{ $move->attribute_log_detail }}
                                            prodotti
                                        </div>
                                    </div>
                                </div>
                                <p></p>
                            @endforeach
                        @endforeach
                    @endisset
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
