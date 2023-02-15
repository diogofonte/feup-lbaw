@extends('layouts.app')

@section('content')
<div id="order_page">
    <h2>Products of the Order #{{$order['id']}}</h2>
    <div id="total">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
            Total price:<span>{{$order->totalPrice($order['id'])}}</span>
            </li>
        </ul>
    </div>
    <div id="order_details">
        @foreach ($order->details as $detail)
            <div class="card mb-3">
                <h3 class="card-header">{{$detail->product['name']}}</h3>
                <div class="card-body">
                    <h5 class="card-title">{{$detail->product['description']}}</h5>
                </div>
                <img src="{{asset($detail->product->images[0]->imageURL())}}" class="d-block user-select-none" width="100%" height="100%" focusable="false"></img>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Size <span>{{$detail['size']['name']}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Color <span>{{$detail['color']['name']}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Quantity <span>{{$detail['quantity']}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Price <span>{{$detail->product['price']}}</span>
                    </li>
                </ul>
                <div class="card-footer text-muted">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="#" class="card-link">Product Page</a>
                </li>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection