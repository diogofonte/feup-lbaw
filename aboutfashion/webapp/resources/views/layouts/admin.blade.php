<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token  -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AboutFashion - Admin Panel</title>

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
<body class="d-flex flex-column min-vh-100">
    <main>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light p-3" style=" z-index: 20;">
                <div class="container-fluid">
                    <a class="navbar-brand mx-4 fw-bold" href="{{ route('homeAdminPanel') }}">
                        ABOUT FASHION - ADMIN PANEL
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class=" collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ms-auto ">
                            <li class="nav-item">
                                <a class="nav-link mx-2" href="{{ route('showAdmin', ['id' => Auth::guard('admin')->user()->id]) }}">
                                    <i class="fa-solid fa-user" style="font-size:24px;"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-2" href="{{ route('adminLogout') }}">
                                    <i class="fa-solid fa-right-from-bracket" style="font-size:24px;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <section id="content">
            @yield('content')
        </section>
        <footer
            class=" bg-light d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top mb-auto"
            style="z-index: 200;">
            <p class="col-md-4 mb-0  mx-3">
                &#169 About Fashion
            </p>
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