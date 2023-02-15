@extends('layouts.app')
@section('content')
    @csrf
    <head>
        <ol class="breadcrumb p-3 pb-1">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Notifications</li>
        </ol>
    </head>
    <body>
        <section class="pb-5">
            <div class="container">
                <h3 class="display-5 mt-3 mb-5 text-left">NOTIFICATIONS</h3>
                <div class="row w-100">
                    <div class="col-lg-12 col-md-12 col-12">
                    @if (is_null($notifications))
                        <p class="mx-4">You don't have notifications.</p>
                    @else
                        <table id="notifications_table" class="table table-condensed mb-4 table-responsive">
                            <thead>
                                <tr>
                                    <th style="width:70%">Notification</th>
                                    <th style="width:30%">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr id="row-{{ $notification['id'] }}" class="row-product-table">
                                            <td class=" align-middle " data-th="Notification">
                                                <div class="row">
                                                    <h4>{{ $notification['title'] }}</h4>
                                                    <p class="font-weight-light"> {{ $notification['description'] }}</p>
                                                </div>
                                            </td>
                                            <td class=" align-middle " data-th="Price">
                                                <div class=" mt-sm-2">
                                                  
                                                    <p class="font-weight-light">{{ $notification['date'] }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    @endif
                    </div>
                </div>
            </div>
        </section>
    </body>


   
@endsection
