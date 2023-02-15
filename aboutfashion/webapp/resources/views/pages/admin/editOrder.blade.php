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
                <h3>Edit Status of order nº{{ $order['id'] }} from user {{ $order->user->name }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <form method="POST" action="{{ route('updateOrder', ['id' => $order->id]) }}">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        @foreach ($order->details as $item)
                            <div class="col-4 pt-4">
                                <div class="card">
                                    <img src="{{ asset($item->product->images[0]->imageURL()) }}" alt="product image" class="img-fluid">
                                    <div class="card-body">
                                        <strong>{{ $item->product->name }}</strong>
                                        <strong>{{ $item->color->name }}</strong>
                                        <strong>{{ $item->size->name }}</strong>
                                        <strong>{{ $product->price }}</strong>
                                        <button type="submit" class="btn btn-outline-warning">Remove</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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