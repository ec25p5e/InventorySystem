@extends('layouts.app')
@section('title', 'Notifiche')

@section('body')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="title">
                            <h4>Notifiche per te</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route(getRoute(Auth::id(), 'DASHBOARD')) }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Notifiche
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="container pd-0">
                <div class="timeline mb-30">
                    @isset($dates)
                        <ul>
                            @foreach($dates as $date)
                                <li>
                                    <div class="timeline-date">{{ formatDatePortal($date->notification_date) }}</div>

                                    @foreach($notificationsForDate($date->created_at) as $notification)
                                        <div class="timeline-desc card-box">
                                            <div class="pd-20">
                                                <h4 class="mb-10 h4">
                                                    {{ $notification->notification_title }}
                                                </h4>
                                                <p>
                                                    {{ $notification->notification_message }}
                                                </p>
                                            </div>
                                        </div>
                                        <p></p>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
