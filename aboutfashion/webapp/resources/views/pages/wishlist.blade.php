@extends('layouts.app')
@section('content')
    <script type="text/javascript" src={{ asset('js/wishlist.js') }} defer></script>

    <head>
        <ol class="breadcrumb p-3 pb-1">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Wishlist</li>
        </ol>
    </head>
    
    <body>
        <section class="pb-5">
            <div class="container">
                <h3 class="display-5 mt-3 mb-5 text-left">WISHLIST</h3>
                <div class="row w-100">
                    <div class="col-lg-12 col-md-12 col-12">
                        <table id="shoppingCart" class="table table-condensed mb-4 table-responsive">
                            <thead>
                                <tr>
                                    <th style="width:56%">Product</th>
                                    <th style="width:12%">Price</th>
                                    <th class="text-center" style="width:12%">Discount</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (is_null($wishlist))
                                @else
                                    @foreach ($wishlist as $likedPiece)
                                        <tr id="row-{{$likedPiece->id}}" class="row-product">
                                            <input type="hidden" id="id-product" value="{{ $likedPiece->id }}">
                                            <td class=" align-middle " data-th="Product">
                                                <div class="row">
                                                    <div class="col-md-3 text-left">
                                                        <img src="{{ asset($likedPiece->images[0]->imageURL()) }}" alt=""
                                                            class="img-fluid d-none d-md-block rounded mt-3 shadow ">
                                                    </div>
                                                    <div class="col-md-9  align-middle text-left mt-sm-2">
                                                        <h4>{{ $likedPiece['name'] }}</h4>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                            <td class=" align-middle " data-th="Price">
                                                <div class=" mt-sm-2">
                                                    @php
                                                        $finalPrice = $likedPiece->getPriceWithPromotion(date('Y-m-d H:i:s'));
                                                    @endphp
                                                    <p class="font-weight-light">{{ $finalPrice }}€ 
                                                        @if ($finalPrice == $likedPiece['price'])
                                                            </p>
                                                        @else
                                                            <small class="dis-price"
                                                                style="color: #888;text-decoration: line-through;">{{ $likedPiece['price'] }}€</small>
                                                            </p>
                                                        @endif
                                                        <span id="original-price-{{ $likedPiece->id }}"
                                                            style="display: none">{{ $likedPiece['price'] }}</span>
                                                        <span id="final-price-{{ $likedPiece->id }}"
                                                            style="display: none">{{ $finalPrice }}</span>

                                                </div>
                                            </td>
                                            <td class=" align-middle text-center" data-th="Discount">
                                                @if ($finalPrice == $likedPiece['price'])
                                                    -
                                                @else
                                                    {{ $likedPiece->getPromotion(date('Y-m-d H:i:s'))->discount }}%
                                                @endif

                                            </td>
                                            <td class="actions align-middle text-center" data-th="">
                                                <div class="text-right justify-content-center">
                                                        <button id="{{ $likedPiece->id }}"
                                                            style="border:none;background-color:#fff;"><i
                                                                class="fa-solid fa-heart button-like " id="{{$likedPiece->id}}"
                                                                style="font-size:1.5rem;"></i></button>

                                                </div>
                                            </td>
                                            </tr>
                                        @endforeach
                
                @endif
                </tbody>
                </table>
                <a href="{{ route('searchProductView') }}" class="mt-5"><i class="fas fa-arrow-left mr-2"></i>Continue
                    Shopping</a>

            </div>
            
            </div>

            </div>
        </section>
    </body>
@endsection
