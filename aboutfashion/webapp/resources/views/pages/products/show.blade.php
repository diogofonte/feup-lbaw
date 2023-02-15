@extends('layouts.app')
@section('content')
    <script type="text/javascript" src={{ asset('js/product.js') }} defer></script>
    <span id="id-product" style="display: none">{{ $product->id }}</span>
    @csrf

    <head>
        <ol class="breadcrumb p-3 pb-1">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('searchProductView') }}">Search</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </head>

    <body style="justify-content-center">
        <div class="container mt-5 mb-5">
            <div class="row d-flex justify-content-center">
                <div class="card mb-5">
                    <div class="row mt-3 mb-3">
                        <div class="col-md-6">
                            <div class="images p-3">
                                <div class="text-center p-4">
                                    <img id="main-image" src="{{ asset($product->images[0]->imageURL()) }}" width="400" />
                                </div>
                                <div class="thumbnail text-center">
                                    @foreach ($product->images as $image)
                                        <img src="{{ asset($image->imageURL()) }}" onclick="change_image(this)" width="70" />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product p-4 mt-3">

                                <div class="mt-4 mb-3">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h3 class="text-uppercase " id="product_name">{{ $product->name }}</h3>
                                        </div>
                                        @if (!Auth::user())
                                        @else
                                            <div class="col-md-1">
                                                @if ($product->wishlist()->where('id_user', Auth::user()->id)->exists())
                                                    <button id="likeIcon"
                                                        style="border:none;background-color:#fff;margin-top:0.3rem;"><i
                                                            class="fa-solid fa-heart " id="heartIcon"
                                                            style="font-size:1.7rem;"></i></button>
                                                @else
                                                    <button id="likeIcon"
                                                        style="border:none;background-color:#fff;margin-top:0.3rem;"><i
                                                            class="fa-regular fa-heart " id="heartIcon"
                                                            style="font-size:1.7rem;"></i></button>
                                                @endif
                                            </div>
                                        @endif

                                    </div>

                                    <div class="price d-flex flex-row align-items-center" id="price">
                                        @php
                                            $finalPrice = $product->getPriceWithPromotion(date('Y-m-d H:i:s'));
                                        @endphp
                                        <span class="act-price">Price: {{ $finalPrice }}€ <input type="hidden" id="final_price" value="{{ $finalPrice }}"></span>
                                        @if ($finalPrice == $product->price)
                                            <div class="ml-2 mx-2"> <small class="dis-price"><input type="hidden" id="product_price" value="{{ $product->price}}"></small></div>
                                        @else
                                            <div class="ml-2 mx-2"> <small class="dis-price"
                                                    style="color: #888;text-decoration: line-through;">{{ $product->price }}€</small>
                                                    <input type="hidden" id="product_price" value="{{ $product->price}}">
                                            </div>
                                        @endif

                                    </div>
                                    @if ($finalPrice == $product->price)
                                        <span id="disc"></span>
                                    @else
                                        <span id="disc">{{ $product->getPromotion(date('Y-m-d H:i:s'))->discount }}%
                                            OFF</span>
                                    @endif
                                </div>



                                <p class="about">{{ $product->description }}</p>
                                <ul class="list-unstyled d-flex  text-warning mb-0">
                                    @for ($t = 1; $t < 6; $t++)
                                        @if ($t > $product->avg_classification)
                                            <li><i class="far fa-star fa-sm"></i></li>
                                        @else
                                            <li><i class="fas fa-star fa-sm"></i></li>
                                        @endif
                                    @endfor
                                </ul>
                                <div class="dropdown mt-3" id="div_color">
                                    <select class="form-select " id="color" name="id_color" style="width:150px">
                                        <option selected>Select color</option>
                                        @foreach ($product->colors()->distinct()->get() as $color)
                                            <option value="{{ $color['id'] }}">
                                                {{ $color['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="div_size">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @if (count($product->reviews) > 0)
            <div class=" d-flex justify-content-center align-items-center text-center mx-auto mt-5 mb-5"
                style="width: 200px;">
                <h3 class="mx-auto" style="">Reviews</h3>
            </div>
            @php
                $n = ceil(count($product->reviews) / 3);
                $j = 0;
            @endphp
            <div id="carouselExampleControls" class="carousel slide carousel-dark text-center mx-3 mb-5"
                data-bs-ride="carousel">
                <div class="carousel-inner">
                    @for ($i = 0; $i < $n; $i++)
                        @if ($i == 0)
                            <div class="carousel-item active">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4 mx-auto">
                                            <p class="text-end"><a type="submit" href="{{ route('createReport', ['id_review' => $product->reviews[$j]['id']]) }}"><button id=""
                                            style="border:none;background-color:#fff;" class="me-5 mt-5"><i class="fa-solid fa-triangle-exclamation" style="font-size:1.1rem;"></i></button></a></p>
                                            <img class="rounded-circle shadow-1-strong mb-4"
                                                src="{{ asset($product->reviews[$j]->user->photo->imageURL()) }}" alt="avatar"
                                                style="width: 150px;" />
                                            <h5 class="mb-3">{{ $product->reviews[$j]->user->first_name }}
                                                {{ $product->reviews[$j]->user->last_name }}</h5>
                                            <p>{{ str_replace('-', '/', strrev(substr($product->reviews[$j]['date'], 0, 10))) }}
                                            </p>
                                            <p class="text-muted">
                                                <i class="fas fa-quote-left pe-2"></i>
                                                {{ $product->reviews[$j]['description'] }}
                                                <i class="fa-solid fa-quote-right ps-2"></i>
                                            </p>
                                            <ul class="list-unstyled d-flex justify-content-center text-warning mb-0">
                                                @for ($t = 1; $t < 6; $t++)
                                                    @if ($t > $product->reviews[$j]['evaluation'])
                                                        <li><i class="far fa-star fa-sm"></i></li>
                                                    @else
                                                        <li><i class="fas fa-star fa-sm"></i></li>
                                                    @endif
                                                @endfor
                                            </ul>
                                        </div>
                                        @php
                                            $j = $j + 1;
                                        @endphp
                                        @if ($j == count($product->reviews))
                                    </div>
                                </div>
                            </div>
                        @break
                    @endif
                    <div class="col-lg-4 mx-auto">
                        <p class="text-end"><a type="submit" href="{{ route('createReport', ['id_review' => $product->reviews[$j]['id']]) }}"><button id=""
                        style="border:none;background-color:#fff;" class="me-5 mt-5"><i class="fa-solid fa-triangle-exclamation" style="font-size:1.1rem;"></i></button></a></p>
                        <img class="rounded-circle shadow-1-strong mb-4"
                            src="{{ asset($product->reviews[$j]->user->photo->imageURL())}}" alt="avatar"
                            style="width: 150px;" />
                        <h5 class="mb-3">{{ $product->reviews[$j]['id_user'] }}</h5>
                        <p>{{ str_replace('-', '/', strrev(substr($product->reviews[$j]['date'], 0, 10))) }}</p>
                        <p class="text-muted">
                            <i class="fas fa-quote-left pe-2"></i>
                            {{ $product->reviews[$j]['description'] }}
                        </p>
                        <ul class="list-unstyled d-flex justify-content-center text-warning mb-0">
                            @for ($t = 1; $t < 6; $t++)
                                @if ($t > $product->reviews[$j]['evaluation'])
                                    <li><i class="far fa-star fa-sm"></i></li>
                                @else
                                    <li><i class="fas fa-star fa-sm"></i></li>
                                @endif
                            @endfor
                        </ul>
                    </div>
                    @php
                        $j = $j + 1;
                    @endphp
                    @if ($j == count($product->reviews))
            </div>
        </div>
        </div>
    @break
@endif
<div class="col-lg-4 mx-auto">
    <p class="text-end"><a type="submit" href="{{ route('createReport', ['id_review' => $product->reviews[$j]['id']]) }}"><button id=""
    style="border:none;background-color:#fff;" class="me-5 mt-5"><i class="fa-solid fa-triangle-exclamation" style="font-size:1.1rem;"></i></button></a></p>
    <img class="rounded-circle shadow-1-strong mb-4" src="{{ asset($product->reviews[$j]->user->photo->imageURL()) }}"
        alt="avatar" style="width: 150px;" />
    <h5 class="mb-3">{{ $product->reviews[$j]['id_user'] }}</h5>
    <p>{{ str_replace('-', '/', strrev(substr($product->reviews[$j]['date'], 0, 10))) }}</p>
    <p class="text-muted">
        <i class="fas fa-quote-left pe-2"></i>
        {{ $product->reviews[$j]['description'] }}
    </p>
    <ul class="list-unstyled d-flex justify-content-center text-warning mb-0">
        @for ($t = 1; $t < 6; $t++)
            @if ($t > $product->reviews[$j]['evaluation'])
                <li><i class="far fa-star fa-sm"></i></li>
            @else
                <li><i class="fas fa-star fa-sm"></i></li>
            @endif
        @endfor
    </ul>
</div>
@php
    $j = $j + 1;
@endphp

</div>
</div>
</div>
@else
<div class="carousel-item">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mx-auto">
                <p class="text-end"> 
                    <a type="submit" href="{{ route('createReport', ['id_review' => $product->reviews[$j]['id']]) }}">
                        <button id="" style="border:none;background-color:#fff;" class="me-5 mt-5">
                            <i class="fa-solid fa-triangle-exclamation" style="font-size:1.1rem;"></i>
                        </button>
                    </a>
                </p>
                <img class="rounded-circle shadow-1-strong mb-4"
                    src="{{ asset($product->reviews[$j]->user->photo->imageURL()) }}" alt="avatar"
                    style="width: 150px;" />
                <h5 class="mb-3">{{ $product->reviews[$j]['id_user'] }}</h5>
                <p>{{ str_replace('-', '/', strrev(substr($product->reviews[$j]['date'], 0, 10))) }}</p>
                <p class="text-muted">
                    <i class="fas fa-quote-left pe-2"></i>
                    {{ $product->reviews[$j]['description'] }}
                </p>
                <ul class="list-unstyled d-flex justify-content-center text-warning mb-0">
                    @for ($t = 1; $t < 6; $t++)
                        @if ($t > $product->reviews[$j]['evaluation'])
                            <li><i class="far fa-star fa-sm"></i></li>
                        @else
                            <li><i class="fas fa-star fa-sm"></i></li>
                        @endif
                    @endfor
                </ul>
            </div>
            @php
                $j = $j + 1;
            @endphp
            @if ($j == count($product->reviews))
        </div>
    </div>
</div>
@break
@endif
<div class="col-lg-4  mx-auto">
<p class="text-end"><a type="submit" href="{{ route('createReport', ['id_review' => $product->reviews[$j]['id']]) }}"><button id=""
style="border:none;background-color:#fff;" class="me-5 mt-5"><i class="fa-solid fa-triangle-exclamation" style="font-size:1.1rem;"></i></button></a></p>
<img class="rounded-circle shadow-1-strong mb-4" src="{{ asset($product->reviews[$j]->user->photo->imageURL()) }}"
    alt="avatar" style="width: 150px;" />
<h5 class="mb-3">{{ $product->reviews[$j]['id_user'] }}</h5>
<p>{{ str_replace('-', '/', strrev(substr($product->reviews[$j]['date'], 0, 10))) }}</p>
<p class="text-muted">
    <i class="fas fa-quote-left pe-2"></i>
    {{ $product->reviews[$j]['description'] }}
</p>
<ul class="list-unstyled d-flex justify-content-center text-warning mb-0">
    @for ($t = 1; $t < 6; $t++)
        @if ($t > $product->reviews[$j]['evaluation'])
            <li><i class="far fa-star fa-sm"></i></li>
        @else
            <li><i class="fas fa-star fa-sm"></i></li>
        @endif
    @endfor
</ul>
</div>
@php
    $j = $j + 1;
@endphp
@if ($j == count($product->reviews))
</div>
</div>
</div>
@break
@endif
<div class="col-lg-4  mx-auto">
<p class="text-end"><a type="submit" href="{{ route('createReport', ['id_review' => $product->reviews[$j]['id']]) }}"><button id=""
style="border:none;background-color:#fff;" class="me-5 mt-5"><i class="fa-solid fa-triangle-exclamation" style="font-size:1.1rem;"></i></button></a></p>
<img class="rounded-circle shadow-1-strong mb-4" src="{{ asset($product->reviews[$j]->user->photo->imageURL()) }}"
alt="avatar" style="width: 150px;" />
<h5 class="mb-3">{{ $product->reviews[$j]['id_user'] }}</h5>
<p>{{ str_replace('-', '/', strrev(substr($product->reviews[$j]['date'], 0, 10))) }}</p>
<p class="text-muted">
<i class="fas fa-quote-left pe-2"></i>
{{ $product->reviews[$j]['description'] }}
</p>
<ul class="list-unstyled d-flex justify-content-center text-warning mb-0">
@for ($t = 1; $t < 6; $t++)
    @if ($t > $product->reviews[$j]['evaluation'])
        <li><i class="far fa-star fa-sm"></i></li>
    @else
        <li><i class="fas fa-star fa-sm"></i></li>
    @endif
@endfor
</ul>
</div>
@php
    $j = $j + 1;
@endphp
</div>
</div>
</div>
@endif
@endfor
</div>

<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
data-bs-slide="prev">
<span class="carousel-control-prev-icon" aria-hidden="true"></span>
<span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
data-bs-slide="next">
<span class="carousel-control-next-icon" aria-hidden="true"></span>
<span class="visually-hidden">Next</span>
</button>
</div>
@endif
</body>
@endsection

