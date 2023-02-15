<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token  -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://propeller.in/components/range-slider/css/nouislider.min.css">
    <link rel="stylesheet" type="text/css" href="http://propeller.in/components/textfield/css/textfield.css">
    <link rel="stylesheet" type="text/css" href="http://propeller.in/components/checkbox/css/checkbox.css">
    <link rel="stylesheet" type="text/css" href="http://propeller.in/components/range-slider/css/range-slider.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/be2806c733.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src={{ asset('js/confirm_passwords.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/search_range.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
</head>

<body class="d-flex flex-column min-vh-100 " style="height: 100%;display: flex;flex-direction: column;">
    @php
        if (!Auth::user()) {
            if (!($order = Session::get('cart'))) {
                $order = null;
            }
        } elseif (
            !($order = Auth::user()
                ->orders()
                ->where('status', 'Shopping Cart')
                ->first())
        ) {
            $order = null;
        }

    @endphp
    <main style="flex: 1;">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light p-3" style=" z-index: 20;">
                <div class="container-fluid">

                    <a class="navbar-brand mx-4 fw-bold" href="{{ route('home') }}">ABOUT FASHION</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class=" collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ms-auto ">
                            <li class="nav-item">
                                <a class="nav-link mx-2" href="/products"><i class="fa-solid fa-magnifying-glass"
                                        style="font-size:24px;"></i></a>
                            </li>
                            @if (Auth::check())
                                <li class="nav-item dropdown " id="notificationsTog">
                                    <a class="nav-link mx-2" href="{{ url('/notifications') }}" >
                                        <i class="fa-regular fa-bell" style="font-size:24px;"></i>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-user" style="font-size:24px;"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"
                                    style=" z-index: 18;">
                                    @if (Auth::check())
                                        <li><span class="dropdown-item">Hello {{ Auth::user()->first_name }} !</span>
                                        </li>
                                        <li><a class="button dropdown-item"
                                                href="{{ route('userView', ['id' => Auth::user()->id]) }}"> See
                                                Profile </a></li>
                                        <li><a class="button dropdown-item" href="{{ route('logout') }}"> Logout </a>
                                        </li>
                                    @endif
                                    @if (!Auth::check())
                                        <li><a class="button dropdown-item" href="{{ url('/login') }}"
                                                data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> Sign In </a>
                                        </li>
                                        <li><a class="button dropdown-item" href="{{ url('/register') }}"
                                                data-bs-toggle="modal" data-bs-target="#staticBackdrop2"> Register </a>
                                        </li>
                                    @endif

                                </ul>
                            </li>
                            @if (Auth::check())
                                <li class="nav-item">
                                    <a class="nav-link mx-2" href="{{ url('/wishlist') }}"><i
                                            class="fa-regular fa-heart" style="font-size:24px;"></i></a>
                                </li>
                            @endif
                            <li class="nav-item dropdown " id="shoppingCartTog">
                                <a class="nav-link mx-2 " href="#" id="navbarDropdownMenuLink2" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <ion-icon name="cart-outline" style="font-size:28px;"></ion-icon>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink2"
                                    id="dropdownSC" style="width:27rem;">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12 mb-2 text-end  checkout">
                                            <button type="button" id="dismissDSC" class="btn-close me-2"
                                                data-bs-dismiss="dropdownSC" aria-label="Close"
                                                style="color:#000;background-color:#000;-webkit-tap-highlight-color:#000;"></button>

                                        </div>
                                    </div>
                                    <table id="shoppingCart" class="table table-condensed mb-4 table-responsive">
                                        <tbody id="shop-pop">

                                            @if (is_null($order))
                                                <tr>
                                                    <td>
                                                        <div
                                                            class="col-lg-12 col-sm-12 col-12 mb-2 text-center checkout">
                                                            <p class="font-weight-light" style="font-size:0.8rem;">
                                                                Shopping cart is empty!</p>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @elseif(Auth::user())
                                                @php
                                                    $detail = $order->details[count($order->details) - 1];
                                                @endphp
                                                <tr>
                                                    <td class=" align-middle justify-content-center"style="width:8rem;"
                                                        data-th="Produtoooooooooooooooooo">
                                                        <div class="row">
                                                            <div class="col-md-6 text-left">
                                                                <img src="{{ asset($detail->product->images[0]->imageURL()) }}"
                                                                    alt=""
                                                                    class="img-fluid d-none d-md-block rounded mt-3 shadow ">
                                                            </div>
                                                            <div
                                                                class="col-md-6  align-middle text-left mt-sm-2 mx-auto">
                                                                <h6 style="font-size:0.8em;">
                                                                    {{ $detail->product['name'] }}</h6>
                                                                <p class="font-weight-light"
                                                                    style="font-size:0.5rem;">Size:
                                                                    {{ $detail->size['name'] }} <br>
                                                                    Color: {{ $detail->color['name'] }} </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class=" align-middle justify-content-center"
                                                        style="width:2rem;" data-th="preço">
                                                        <div class=" mt-sm-2">
                                                            @php
                                                                $finalPrice = $detail->product->getPriceWithPromotion(date('Y-m-d H:i:s'));
                                                            @endphp
                                                            <p class="font-weight-light" style="font-size:0.7rem;">
                                                                {{ $finalPrice }}€
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
                                <td class=" align-middle justify-content-center" style="width:3rem;"
                                    data-th="quanti">
                                    <input readonly type="number" style="margin:0;"
                                        class="form-control form-control-sm text-center update-quantity"
                                        value="{{ $detail->quantity }}" min="1"
                                        style="padding:0;width:2.5rem;" id={{ $detail->id }}>
                                    <span id="quantity-{{ $detail->id }}"
                                        style="display: none">{{ $detail->quantity }}</span>
                                </td>
                                <td class="actions align-middle " style="width:2rem" data-th="">
                                    <div class="text-right justify-content-center">
                                        <button class="btn btn-white d-flex mx-auto bg-white btn-md delete-detail "
                                            id={{ $detail->id }}>
                                            <i class="fas fa-trash" id={{ $detail->id }}></i>
                                        </button>
                                    </div>
                                </td>
                                </tr>
                            @elseif(!Auth::user())
                                @php
                                    $id = end($order)['id'];
                                    $product = \App\Models\Product::find(end($order)['id_product']);
                                    $size = \App\Models\Size::find(end($order)['id_size']);
                                    $color = \App\Models\Color::find(end($order)['id_color']);
                                    $quantity = end($order)['quantity'];
                                @endphp
                                <tr>
                                    <td class=" align-middle justify-content-center"style="width:8rem;"
                                        data-th="Produtoooooooooooooooooo">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <img src="{{ asset($product->images[0]->imageURL()) }}" alt=""
                                                    class="img-fluid d-none d-md-block rounded mt-3 shadow ">
                                            </div>
                                            <div class="col-md-6  align-middle text-left mt-sm-2 mx-auto">
                                                <h6 style="font-size:0.8em;">
                                                    {{ $product->name }}</h6>
                                                <p class="font-weight-light" style="font-size:0.5rem;">Size:
                                                    {{ $size->name }} <br>
                                                    Color: {{ $color->name }} </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=" align-middle justify-content-center" style="width:2rem;"
                                        data-th="preço">
                                        <div class=" mt-sm-2">
                                            @php
                                                $finalPrice = $product->getPriceWithPromotion(date('Y-m-d H:i:s'));
                                            @endphp
                                            <p class="font-weight-light" style="font-size:0.7rem;">
                                                {{ $finalPrice }}€
                                                @if ($finalPrice == $product['price'])
                                            </p>
                                        @else
                                            <small class="dis-price"
                                                style="color: #888;text-decoration: line-through;">{{ $product['price'] }}€</small>
                                            </p>
                                            @endif
                                            <span id="original-price-{{ $id }}"
                                                style="display: none">{{ $product['price'] }}</span>
                                            <span id="final-price-{{ $id }}"
                                                style="display: none">{{ $finalPrice }}</span>

                                        </div>
                                    </td>
                                    <td class=" align-middle justify-content-center" style="width:3rem;"
                                        data-th="quanti">
                                        <input readonly type="number" style="margin:0;"
                                            class="form-control form-control-sm text-center update-quantity"
                                            value="{{ $quantity }}" min="1"
                                            style="padding:0;width:2.5rem;" id={{ $id }}>
                                        <span id="quantity-{{ $id }}"
                                            style="display: none">{{ $quantity }}</span>
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12 mb-2 text-center checkout">
                                        <a href="{{ route('shoppingCartView') }}">
                                            <button class="btn btn-primary btn-block"
                                                style="background-color:rgba(0,0,0,.9);border-color:rgba(0,0,0,.9);">View
                                                shopping cart</button>
                                        </a>

                                    </div>
                                </div>
                    </div>
                    </li>
                    </ul>
                </div>
                </div>
            </nav>
            <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">SIGN IN</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('userLogin') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="email" class="form-label mt-4">Email address*</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        required autofocus class="form-control" placeholder="Enter email">
                                    <small>Please enter your email address.</small>
                                    @if ($errors->has('email'))
                                        <span class="error">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label mt-4">Password*</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Password" name="password" required>
                                    <small>Please enter your password.</small>
                                    @if ($errors->has('password'))
                                        <span class="error">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Remember Me
                                    </label>
                                </div>
                                <div class="modal-footer">
                                    <a class="button button-outline me-auto" href="{{ url('/forgot-password') }}"
                                        data-bs-dismiss="modal" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop3">Forgot password?</a>
                                    <!-- meter 'home' -->
                                    <button type="submit" class="btn btn-secondary">Login</button>
                                    <button type="button" class="btn btn-primary"><a
                                            class="button button-outline nav-link" href="{{ route('userRegister') }}"
                                            data-bs-dismiss="modal" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop2">Register</a></button>
                                    <!-- meter 'home' -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">REGISTER</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('userRegister') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="first_name" class="form-label mt-4">First Name*</label>
                                    <input type="text" class="form-control" id="first_name"
                                        placeholder="First Name" name="first_name" required>
                                    <small>Please enter your first name.</small>
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="form-label mt-4">Last Name*</label>
                                    <input type="text" class="form-control" id="last_name"
                                        placeholder="Last Name" name="last_name" required>
                                    <small>Please enter your last name.</small>
                                </div>
                                <div class="form-group">
                                    <label for="email1" class="form-label mt-4">Email address*</label>
                                    <input id="email1" type="text" name="email" required autofocus
                                        class="form-control" placeholder="Enter email">
                                    <small>Please enter your email address.</small>
                                    @if ($errors->has('email'))
                                        <span class="error">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label mt-4">Password*</label>
                                    <input type="password" class="form-control" id="password1"
                                        placeholder="Password" name="password" required>
                                    <small>Please enter your password.</small>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label mt-4">Confirm Password*</label>
                                    <input type="password" class="form-control" id="password2"
                                        placeholder="Password" name="password" required>
                                    <small>Please enter your password again.</small>
                                </div>

                                <div class="form-group">
                                    <div class=" me-auto"></div>
                                    <label for="gender" class="form-label mt-4">Gender</label>
                                    <select class="form-select" name="gender">
                                        <option selected>Select gender</option>
                                        <option value="F">FEMALE</option>
                                        <option value="M">MALE</option>
                                        <option value="O">OTHER</option>
                                    </select>
                                    <small>Please choose your gender.</small>
                                </div>
                                <div class="form-group mb-5">
                                    <div class=" me-auto"></div>
                                    <label for="birthdate" class="form-label mt-4">Birthdate</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate">
                                    <small>Please enter your birthdate.</small>
                                </div>
                                <div class="modal-footer">
                                    <span class="error-text me-auto" style="color:red"> </span>
                                    <button type="submit" class="btn btn-primary reg">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">FORGOTTEN PASSWORD</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row text-center mb-3">
                                <p>If you've forgotten your password, please enter your registered email address. <br>
                                    We'll send you a link to reset your password.</p>
                            </div>
                            <form method="POST" action="{{ route('forgot.password.action') }}">
                                {{ csrf_field() }}
                                <div class="form-group mb-4">
                                    @if ($errors->has('email'))
                                        <span class="error">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @else
                                    @endif
                                    <input id="email" type="email" name="email" value=""
                                        style="width:100%;" required>
                                    <small class="mx-auto" style="text-align:center;">Please enter your email
                                        address.</small>
                                </div>


                                <div class="modal-footer">
                                    <button type="submit" class="btn mx-auto btn-primary reg">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </header>
        <section id="content" style="height:100%">
            @yield('content')
        </section>

        <footer
            class=" bg-light d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top mb-auto"
            style="z-index: 200;  position:relative;
  left: 0;
  bottom: 0;width: 100%;text-align: center;">
            <p class="col-md-4 mb-0  mx-3"> &#169 About Fashion</p>
            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item"> <a href="/about"
                        class="nav-link px-2 mx-2 link-primary text-decoration-underline link-primary:hover">About
                        Us</a></li>
                <li class="nav-item"> <a href="/contacts"
                        class="nav-link px-2 mx-2 link-primary text-decoration-underline link-primary:hover">Contacts</a>
                </li>
                <li class="nav-item"> <a href="/help"
                        class="nav-link px-2 mx-2 link-primary text-decoration-underline link-primary:hover">Help</a>
                </li>
                <li class="nav-item"> <a href=""
                        class="nav-link px-2 mx-2 link-primary text-decoration-underline link-primary:hover">Follow
                        Us</a></li>
            </ul>
        </footer>

    </main>
    <!-- Jquery js -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Slider js  -->
    <script src="http://propeller.in/components/range-slider/js/wNumb.js"></script>
    <script src="http://propeller.in/components/range-slider/js/nouislider.js"></script>


</body>

</html>
