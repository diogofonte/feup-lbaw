@extends('layouts.app')
@section('content')
    @csrf
    <script type="text/javascript" src={{ asset('js/shopping_cart.js') }} defer></script>

    <head>
        <ol class="breadcrumb p-3 pb-1">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Shopping Cart</li>
        </ol>
    </head>

    <body>
        <section class="pb-5">
            <div class="container">
                <h3 class="display-5 mt-3 mb-5 text-left">SHOPPING CART</h3>
                <div class="row w-100">
                    <div class="col-lg-8 col-md-8 col-8">
                        <table id="shoppingCart" class="table table-condensed mb-4 table-responsive">
                            <thead>
                                <tr>
                                    <th style="width:56%">Product</th>
                                    <th style="width:12%">Price</th>
                                    <th style="width:12%">Discount</th>
                                    <th style="width:8%">Quantity</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (is_null($order) and is_null($guestCart))
                                @elseif (is_null($guestCart))
                                    @foreach ($order->details as $detail)
                                        <tr id="row-{{ $detail->id }}" class="row-product-table">
                                            <td class=" align-middle " data-th="Product">
                                                <div class="row">
                                                    <div class="col-md-3 text-left">
                                                        <img src="{{ asset($detail->product->images[0]->imageURL()) }}" alt=""
                                                            class="img-fluid d-none d-md-block rounded mt-3 shadow ">
                                                    </div>
                                                    <div class="col-md-9  align-middle text-left mt-sm-2">
                                                        <h4>{{ $detail->product['name'] }}</h4>
                                                        <p class="font-weight-light">Size: {{ $detail->size['name'] }} <br>
                                                            Color: {{ $detail->color['name'] }} </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class=" align-middle " data-th="Price">
                                                <div class=" mt-sm-2">
                                                    @php
                                                        $finalPrice = $detail->product->getPriceWithPromotion(date('Y-m-d H:i:s'));
                                                    @endphp
                                                    <p class="font-weight-light">{{ $finalPrice }}€
                                                        @if ($finalPrice == $detail->product['price'])
                                                    </p>
                                                @else
                                                    <small class="dis-price"
                                                        style="color: #888;text-decoration: line-through;">{{ $detail->product['price'] }}€</small>
                                                    </p>
                                    @endif
                                    <span id="original-price-{{ $detail->id }}"
                                        style="display: none">{{ $detail->product['price'] }}</span>
                                    <span id="final-price-{{ $detail->id }}"
                                        style="display: none">{{ $finalPrice }}</span>

                    </div>
                    </td>
                    <td class=" align-middle text-center" data-th="Discount">
                        @if ($finalPrice == $detail->product['price'])
                            -
                        @else
                            {{ $detail->product->getPromotion(date('Y-m-d H:i:s'))->discount }}%
                        @endif

                    </td>
                    <td class=" align-middle " data-th="Quantity ">
                        <input type="number" class="form-control form-control-sm text-center update-quantity"
                            value="{{ $detail->quantity }}" min="1" id={{ $detail->id }}>
                        <span id="quantity-{{ $detail->id }}" style="display: none">{{ $detail->quantity }}</span>
                    </td>
                    <td class="actions align-middle " data-th="">
                        <div class="text-right justify-content-center">
                            <button class="btn btn-white d-flex mx-auto bg-white btn-md delete-detail "
                                id={{ $detail->id }}>
                                <i class="fas fa-trash" id={{ $detail->id }}></i>
                            </button>
                        </div>
                    </td>
                    </tr>
                    @endforeach
                @else
                    @foreach ($guestCart as $detail)
                        <tr id="row-{{ $detail['id'] }}" class="row-product-table">
                            <td class=" align-middle " data-th="Product">
                                <div class="row">
                                    <div class="col-md-3 text-left">
                                        <img src="{{ asset($detail['product']->images[0]->imageURL()) }}" alt=""
                                            class="img-fluid d-none d-md-block rounded mt-3 shadow ">
                                    </div>
                                    <div class="col-md-9  align-middle text-left mt-sm-2">
                                        <h4>{{ $detail['product']->name }}</h4>
                                        <p class="font-weight-light">Size: {{ $detail['size']->name }} <br>
                                            Color: {{ $detail['color']->name }} </p>
                                    </div>
                                </div>
                            </td>
                            <td class=" align-middle " data-th="Price">
                                <div class=" mt-sm-2">
                                    @php
                                        $finalPrice = $detail['product']->getPriceWithPromotion(date('Y-m-d H:i:s'));
                                    @endphp
                                    <p class="font-weight-light">{{ $finalPrice }}€
                                        @if ($finalPrice == $detail['product']->price)
                                    </p>
                                @else
                                    <small class="dis-price"
                                        style="color: #888;text-decoration: line-through;">{{ $detail['product']->price }}€</small>
                                    </p>
                    @endif
                    <span id="original-price-{{ $detail['id'] }}"
                        style="display: none">{{ $detail['product']->price }}</span>
                    <span id="final-price-{{ $detail['id'] }}" style="display: none">{{ $finalPrice }}</span>

                </div>
                </td>
                <td class=" align-middle text-center" data-th="Discount">
                    @if ($finalPrice == $detail['product']->price)
                        -
                    @else
                        {{ $detail['product']->getPromotion(date('Y-m-d H:i:s'))->discount }}%
                    @endif

                </td>
                <td class=" align-middle " data-th="Quantity ">
                    <input type="number" class="form-control form-control-sm text-center update-quantity"
                        value="{{ $detail['quantity'] }}" min="1" id={{ $detail['id'] }}>
                    <span id="quantity-{{ $detail['id'] }}" style="display: none">{{ $detail['quantity'] }}</span>
                </td>
                <td class="actions align-middle " data-th="">
                    <div class="text-right justify-content-center">
                        <button class="btn btn-white d-flex mx-auto bg-white btn-md delete-detail "
                            id={{ $detail['id'] }}>
                            <i class="fas fa-trash" id={{ $detail['id'] }}></i>
                        </button>
                    </div>
                </td>
                </tr>
                @endforeach
                @endif
                </tbody>
                </table>
                <a href="{{ route('searchProductView') }}" class="mt-5"><i class="fas fa-arrow-left mr-2"></i> Continue
                    Shopping</a>

            </div>
            <div class=" col-lg-4 col-md-4 col-4">
                <div class=" card mt-5" style="border-color: #dee2e6;border-radius: 0;">
                    <h4 class="mt-5 mx-5" style="">OVERVIEW</h4>
                    <div class="col mx-5 mb-5 my-2">
                        <div class="d-flex justify-content-between my-3 information">
                            <span>Subtotal</span><span id="subtotal"></span>
                        </div>
                        <div class="d-flex justify-content-between my-3 information">
                            <span>Discount</span><span id="discount"></span>
                        </div>
                        <div class="d-flex justify-content-between my-3 information">
                            <span>Total</span><span id="total" style="padding: 0;"></span>
                        </div>
                        <button class="btn btn-primary btn-block d-flex mx-auto mt-5"
                            style="background-color:rgba(0,0,0,.9);" type="button"><a href="{{ route('checkout') }}" style="color:#fff;text-decoration: none;" ><span>Checkout</span></a></button>
                    </div>
                </div>
            </div>
            </div>

            </div>
        </section>
    </body>
@endsection
