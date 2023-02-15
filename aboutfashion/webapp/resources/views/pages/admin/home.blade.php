@extends('layouts.admin')

@php
    $admin = Auth::guard('admin')->user();
@endphp

@section('content')
    <div class="container">
        <div class="row pt-3">
            <h2>Welcome {{ $admin['first_name'] . ' ' . $admin['last_name'] }}!</h2>
            <h4 class="text-info">{{ $admin['role'] }}</h4>
        </div>
        <div class="row pt-4">
            <div class="col">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-4">
                        <div class="row">    
                            <a type="button" class="btn btn-outline-primary btn-lg" 
                                    href="{{ route('usersAdminPanel') }}">
                                Users
                            </a>
                        </div>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-4">
                        <div class="row">
                            <a type="button" class="btn btn-outline-primary btn-lg"
                                    href="{{ route('productsAdminPanel') }}">
                                Products
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-1"></div>
                    <div class="col-4">
                        <div class="row">
                            <a type="button" class="btn btn-outline-primary btn-lg"
                                    href="{{ route('promotionsAdminPanel') }}">
                                Promotions
                            </a>
                        </div>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-4">
                        <div class="row">
                            <a type="button" class="btn btn-outline-primary btn-lg"
                                    href="{{ route('ordersAdminPanel') }}">
                                Orders
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-1"></div>
                    <div class="col-4">
                        <div class="row">
                            <a type="button" class="btn btn-outline-primary btn-lg"
                                    href="{{ route('reviewsAdminPanel') }}">
                                Reviews
                            </a>
                        </div>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-4">
                        <div class="row">
                            <a type="button" class="btn btn-outline-primary btn-lg"
                                    href="{{ route('reportsAdminPanel') }}">
                                Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection