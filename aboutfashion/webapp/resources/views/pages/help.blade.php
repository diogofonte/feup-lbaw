@extends('layouts.app')

@section('content')
  <div class="container">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mt-3">
        <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Help</li>
      </ol>
    </nav>
    <h1 class="mt-3">Help</h1>
    <hr>

    <section class="py-3">
      <div class="row">
          <h3> FAQ</h3>
          <h5 class="mt-2">Do I have to register to shop?</h5>
          <small>Yes you need to have an account to shop</small>
          <h5 class="mt-2">Can I cancel my order?</h5>
          <small>Yes you can cancel your order in the user profile unless the order is completed.</small>
          <h5 class="mt-2">Who made this website?</h5>
          <small> You can find more about our team in the <a href="/about">about page</a>.</small>
          <h5 class="mt-2">What if someone does comment an inappropriate comment?</h5>
          <small>Our site is constantly monitored by admins from all over the world. They analyse reports made by users and issue the correct responses. If you violate our terms of conduct, you may be banned for a determined ammount of time (maybe forever).</small>
      </div>
    </section>

    <section class="pb-3 mt-4">
    <div class="row">
        <h3> HELP FORM</h3>

        <div class="card mt-3">
        <form method="POST" action="{{ route('userRegister') }}" >
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email" class="form-label mt-4">Email address</label>
                <input id="email" type="text" name="email" required autofocus
                    class="form-control" placeholder="Enter email">
                <small>Please enter your email address.</small>
                @if ($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="form-group mt-5">
                <textarea id="report-description" name="report-description"  style="width: 100%;height: 100px;padding: 12px 20px;box-sizing: border-box;border: 1px solid rgb(206,212,218);border-radius: 4px;font-size: 16px;resize: none;"></textarea><br>
                <small>Please enter in this field your question.</small>
            </div>
            <div class="modal-footer">
                <span class="error-text me-auto" style="color:red"> </span>
                <button type="submit" class="btn btn-primary mx-2 my-2 ">Send</button>
            </div>

        </form>
        </div>
        
          
      </div>
      
      
    </section>
  </div>
@endsection