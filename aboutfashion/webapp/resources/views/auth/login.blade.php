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
                <div class="card-body p-5 text-center" >
                  <h3 class="mb-5 ">Sign in - Admin Panel</h3>
                  <form method="POST" action="{{ route('adminLogin') }}">
                    {{ csrf_field() }}
                    <div class="form-group text-start">
                      <label for="email" class="form-label mt-4 ">Email address</label>
                      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control"  placeholder="Enter email">
                      @if ($errors->has('email'))
                        <span class="error">
                          {{ $errors->first('email') }}
                        </span>
                      @endif
                    </div>
                    <div class="form-group text-start">
                      <label for="password" class="form-label mt-4 ">Password</label>
                      <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                      @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                      @endif
                    </div>
                    <div class="form-check mt-4 text-start">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault_login_Admin" name="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="form-check-label" for="flexCheckDefault_login_Admin">
                          Remember Me
                      </label>
                    </div>
                    <div class="form-check mt-4">
                      <a class="button button-outline  mt-4" href="{{ route('home') }}">
                        Go back to user's homepage
                      </a>
                    </div>
                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary">
                      Login
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


