@extends('layouts.app')

@section('content')
    <script type="text/javascript" src={{ asset('js/search.js') }} defer></script>
    <div class="container-fluid mt-5 ">

        <div class="row mb-5">
            <div class="col-sm-3 col-md-3 col-lg-3 align-content-center justify-content-center mb-5">
                <div class="row mx-auto">
                    <ul class="nav nav-pills flex-column mb-3" style="padding-right:0;">
                        <li class="nav-item text-center">
                            <a class="nav-link active" href=""
                                style="background-color:#ecf0f1; color:#212529; font-size: 24px;">Filters</a>
                        </li>
                    </ul>

                    <div class="card h-100 shadow costum-card text-center mx-auto">
                        <input type="hidden" id="url_api" value="/api/products?">
                        <form class="mt-4 mb-4 " method="GET">
                            <fieldset>
                                <div class="card-group ">

                                    <h5 class="text-start ms-2">CATEGORIES</h5>
                                    <fieldset class="form-group mx-3" style="width:100%; margin-top:1rem;">
                                        <select class="form-select select " id="category" name="id_category">
                                            <option selected >Select category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category['id'] }}">
                                                    {{ $category['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="card-group mt-4  ">
                                    <h5 class="text-start ms-2">SIZE</h5>
                                    <fieldset class="form-group mx-3" style="width:100%; margin-top:1rem;">
                                        <select class="form-select select" name="id_size" id="size">
                                            <option selected>Select size</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size['id'] }}">
                                                    {{ $size['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="card-group mt-4  ">
                                    <h5 class="text-start ms-2">COLOR</h5>
                                    <fieldset class="form-group mx-3" style="width:100%; margin-top:1rem;">
                                        <select class="form-select select" id="color" name="id_color">
                                            <option selected>Select color</option>
                                            <option><i class="fa-solid fa-stop" style="background-color:blue;"></i> Blue
                                            </option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color['id'] }}">
                                                    {{ $color['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="card-group mt-4 ">
                                    <h5 class="text-start ms-2">PRICE</h5>
                                    <p class="text-center ms-auto me-3 "><span id="value-min"></span> € - <span id="value-max"></span> €</p>
                                    <div class="container" id="c1">
                                        <div class="row1 mx-auto">
                                            <div id="pmd-slider-value-range" class="pmd-range-slider" min="0"
                                                max="200" style="margin-top:1rem;"></div>
                                        </div>


                                    </div>
                                </div>
                                <div class="card-group mt-4 ">
                                    <h5 class="text-start ms-2 mt-3 ">CLASSIFICATION</h5> 
                                    <p class="text-center ms-auto me-4 mt-3"><span id="slider-range-value"></span> - 5</p>
                                    <div class="container align-middle" id="c1">
                                    <div class="row1 mx-auto">
                                            <div id="pmd-slider-value-range2" class="pmd-range-slider" min="0"
                                                max="200" style="margin-top:1rem;"></div>
                                    </div>
                                    </div>
                                    
                                </div>
                                <div class="card-group mt-4 ">
                                    <button type="button" class="btn btn-primary mx-auto" id="filterButton"
                                        style="background-color:#000;">
                                        Search
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 col-md-9 col-lg-9 ">
                <div class="row mb-4 ms-5 mt-1">
                    <input type="text" class="ms-1" id="fname" name="product_name" placeholder="Search..."
                        style="width:60%;display:inline;">
                    <button type="button" class="btn btn-primary justify-content-center align-content-center "
                        id="searchButton" style="background-color:#fff;width:7%;border:none;"><i
                            class="fa-solid fa-magnifying-glass mx-auto"
                            style="font-size:25px;width:6%;color:#000; "></i></button>

                    <form method="GET" class="ms-auto" style="display:inline;width:20%;">
                        <select class="form-select" name="order" id="order"
                            style="background-color:#ecf0f1;  display:inline; border: none; color:#212529; font-size: 18px;">
                            <option value="Order" selected>Order</option>
                            <option value="price_asc">Smaller price </option>
                            <option value="price_desc"> Bigger price </option>
                            <option value="avg_desc"> Discount </option>
                            <option value="name_asc"> Product name (a-z) </option>
                            <option value="name_desc"> Product name (z-a) </option>
                        </select>
                    </form>
                </div>
                <div class="spinner-border text-primary mx-auto " id="spinner" role="status" style="margin-top:240px;color:#212529;font-size: 30px;width: 6rem; height: 6rem">
                </div>
                <div class="container mx-auto" id="data-output">

                </div>

            </div>
        </div>
    </div>
@endsection
