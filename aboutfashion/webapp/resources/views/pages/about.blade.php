@extends('layouts.app')

@section('content')
  <div class="container">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mt-3">
        <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">AboutUs</li>
      </ol>
    </nav>
    <h1 class="mt-3">About Us</h1>
    <hr>

    <section class="py-3">
      <div class="row">
          <h3> ABOUT FASHION</h3>
          <p>This is a information system available through the web for for the sale of clothing, accessories and footwear, aimed at adults. This platform allows users to easily keep abreast of items/promotions currently available. This system have operations to consult the information, request and return individual items, make purchases online, register comments for the items, evaluate the ordered items and manage all your data present the personal account.</p>
      </div>
    </section>

    <section class="pb-3">
      <h2 class="my-3">Our Team</h2>
      <hr>
      <div class="row text-center py-3">
        <div class="col-md-3 d-flex justify-content-center">
          <div class="card text-center" style="width: 11rem;">
            <div class="card-body">
              <h5 class="card-title">Alexandre Correia</h5>
              <p class="card-text">up202007042</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 d-flex justify-content-center height: 8rem;">
          <div class="card " style="width: 11rem;">
            <div class="card-body my-auto">
              <h5 class="card-title">Ana Sofia Costa</h5>
              <p class="card-text">up202007602</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 d-flex justify-content-center">
          <div class="card" style="width: 11rem;">
            <div class="card-body">
              <h5 class="card-title">Daniel Rodrigues</h5>
              <p class="card-text"> up202006562</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 d-flex justify-content-center">
          <div class="card text-center" style="width: 11rem;">
            <div class="card-body">
              <h5 class="card-title">Diogo Fonte</h5>
              <p class="card-text">up202004175</p>
            </div>
          </div>
        </div>
      </div>
      
    </section>
  </div>
@endsection