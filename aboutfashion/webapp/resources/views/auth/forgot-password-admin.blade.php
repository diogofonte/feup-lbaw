
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token  -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/be2806c733.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src={{ asset('js/confirm_passwords.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
  </head>
  <body>
  <main>
    <section class="vh-100" style="background-color: #ffffff;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5 ">FORGOT PASSWORD</h3>

                            <form method="POST" action="{{ route('forgot.password.admin.action') }}">
                                @csrf
                                <div class="row text-center mb-3">
                                <p>If you've forgotten your password, please enter your registered email address. <br>
                                     We'll send you a link to reset your password.</p>
                                </div>
                                <div class="form-group mb-4">
                                    @if ($errors->has('email'))
                                        <span class="error">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @else
                                    @endif
                                    <input id="email" type="email" name="email" value="" style="width:100%;" required>
                                    <small class="mx-auto" style="text-align:center;">Please enter your email address.</small>
                                </div>


                                <hr class="my-4">
                                <button type="submit" class="btn btn-primary">
                                    Send
                                </button>


                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>
</html>
