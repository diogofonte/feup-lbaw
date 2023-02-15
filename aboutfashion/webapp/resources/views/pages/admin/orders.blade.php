@extends('layouts.admin')

@section('content')
    @csrf
    <script type="text/javascript" src={{ asset('js/order_admin.js') }} defer></script>
    <div class="container">
        <div class="row">
            <h2 class="p-3 pb-5">Orders</h2>
        </div>
        <div class="row mb-5">
            <!--<div class="col-6"></div>
            <div class="col-6 mb-3">
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>-->
            <div class="row-12">
                <div class="accordion" id="accordion">
                    @foreach($orders as $order)
                        @if (in_array($order->status, ["Completed", "Pending", "Cancelled", "In Progress"]))
                        <div class="accordion-item" id="accordion-item-{{ $order->id }}">
                            <h2 class="accordion-header" id="heading{{$order->id}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapse{{$order->id}}" aria-expanded="true" 
                                        aria-controls="collapse{{$order->id}}">
                                    <div class="col-1">
                                        ID: {{ $order['id'] }}
                                    </div>
                                    @if ($order->status == "Completed")
                                        <div class="col-3">
                                            {{ $order->user['first_name'] . ' ' . $order->user['last_name'] }}
                                            <span class="badge bg-success ms-3">Completed</span>
                                        </div>
                                    @elseif ($order->status == "Pending")
                                        <div class="col-3">
                                            {{ $order->user['first_name'] . ' ' . $order->user['last_name'] }}
                                            <span class="badge bg-warning ms-3">Pending</span>
                                        </div>
                                    @elseif ($order->status == "Cancelled")
                                        <div class="col-3">
                                            {{ $order->user['first_name'] . ' ' . $order->user['last_name'] }}
                                            <span class="badge bg-danger ms-3">Cancelled</span>
                                        </div>
                                    @elseif ($order->status == "In Progress")
                                        <div class="col-3">
                                            {{ $order->user['first_name'] . ' ' . $order->user['last_name'] }}
                                            <span class="badge bg-info ms-3">In Progress</span>
                                        </div>
                                    @else <!-- $order->status == "Shopping Cart" -->
                                        @continue
                                    @endif
                                </button>
                            </h2>
                            <div id="collapse{{$order->id}}" class="accordion-collapse collapse" 
                                aria-labelledby="heading{{$order->id}}" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-2">
                                            @foreach ($order->details as $details)
                                                <img src="{{ asset($details->product->images[0]->imageURL()) }}" 
                                                    class="img-fluid" alt="Responsive image">
                                                <div class="pt-3 text-center">
                                                    <strong>{{$details->product['name']}}</strong>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-9">
                                            <h4>Total Price:</h4>  {{$order->totalPrice($order['id'])}} €
                                            <br>
                                            <br>
                                            <strong>Order date:</strong>  {{ substr($order['date'], 0, 10) }}
                                        </div>
                                        @if (Auth::guard('admin')->user()->role == 'Collaborator')
                                            <div class="col-1">
                                                <div class="row">
                                                    <a type="submit" class="btn btn-warning btn-sm mb-3"
                                                        href="{{ route('editOrderStatus', ['id' => $order->id]) }}">
                                                        <i class="fa-solid fa-pencil"></i>
                                                        &nbsp;
                                                        edit status
                                                    </a>
                                                </div>
                                                <!--<div class="row">
                                                    <a type="submit" class="btn btn-primary btn-sm mb-3"
                                                        href="{{ route('editOrder', ['id' => $order->id]) }}">
                                                        <i class="fa-solid fa-pencil"></i>
                                                        &nbsp;
                                                        edit
                                                    </a>
                                                </div> -->
                                                <!--<div class="row">
                                                    <button class="btn btn-danger btn-sm fa-solid fa-xmark delete-order"
                                                            id="{{ $order->id }}">
                                                    </button>
                                                </div> -->
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div style="padding-top:1em;">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection