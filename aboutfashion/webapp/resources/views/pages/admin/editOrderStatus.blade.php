@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h2 class="p-3 pb-5">Orders</h2>
        </div>
        <div class="row">
            <div class="col-1">
                <a href="/admin-panel/products">
                    <i class="fa-solid fa-arrow-left fa-2x"></i>
                </a>
            </div>
            <div class="col">
                <h3>Edit Status of order nº{{ $order['id'] }} from user {{ $order['user']->first_name . ' ' . $order['user']->last_name}}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <form method="POST" action="{{ route('updateOrderStatus', ['id' => $order->id]) }}">
                    @csrf
                    @method('patch')
                    <!-- Category -->
                    <label for="statusSelect" class="form-label mt-4">Status</label>
                    <select class="form-select" id="statusSelect" name="status" value="{{$order['status']}}">
                        <option value="{{ $order['status'] }}" selected>{{ $order->status }}</option>
                        @foreach ($status_enum as $status)
                            @if ($status != 'Shopping Cart' && $status != $order['status'])
                                <option value="{{$status}}">{{$status}}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="modal-footer p-5 pe-0">
                        <span class="error-text me-auto" style="color:red"> </span>
                        <button type="submit" class="btn btn-primary reg btn-lg">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
@endsection