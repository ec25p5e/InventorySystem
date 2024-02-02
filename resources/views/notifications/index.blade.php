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
                    @isset($dates)
                        @foreach($dates as $date)
                            <div class="time-label">
                                <span class="bg-green">{{ formatDatePortal($date->notification_date) }}</span>
                            </div>

                            @foreach($notificationsForDate($date->created_at) as $notification)
                                <p></p>
                                <div>
                                    <i class="fas fa-solid fa-bell bg-info"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-solid fa-clock"></i> {{ formatDateTime($notification->created_at) }}</span>
                                        <h3 class="timeline-header">{{ $notification->notification_title }}</h3>
                                        <div class="timeline-body">
                                            {{ $notification->notification_message }}
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
