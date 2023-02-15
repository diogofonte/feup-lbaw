@extends('layouts.app')

@section('content')
  <div class="container">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mt-3">
        <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
      </ol>
    </nav>
    <h1 class="my-3">Contacts</h1>
    <hr>

    <!-- Content Row -->
    <div class="row pb-3">
      <!-- Map Column -->
      <div class="col-md-8">
        <!-- Embedded Google Map -->
        <iframe width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=41.177967,-8.5960284&amp;t=m&amp;z=15&amp;output=embed"></iframe>
      </div>
      <!-- Contact Details Column -->
      <div class="col-md-4">
        <h3>Contact details</h3>
        <p>
          Faculdade de Engenharia (FEUP)<br>Rua Dr. Roberto Frias<br>4200-465 PORTO<br>
        </p>
        <p><i class="fa fa-envelope"></i>
        Alexandre Correia - <abbr title="Email"></abbr> <a href="mailto:up202007042@edu.fe.up.pt">up202007042@edu.fe.up.pt</a>
        </p>
        <p> <i class="fa fa-envelope"></i>
        Ana Sofia Costa - <abbr title="Email"></abbr> <a href="mailto:up202007602@edu.fe.up.pt">up202007602@edu.fe.up.pt</a>
        </p>
        <p><i class="fa fa-envelope"></i>
        Daniel Rodrigues - <abbr title="Email"></abbr> <a href="mailto:up202006562@edu.fe.up.pt">up202006562@edu.fe.up.pt</a>
        </p>
        <p><i class="fa fa-envelope"></i>
        Diogo Fonte - <abbr title="Email"></abbr> <a href="mailto:up202004175@edu.fc.up.pt"> up202004175@edu.fc.up.pt</a>
        </p>
        <p><i class="fa fa-clock"></i>
          <abbr title="Hours"></abbr> Monday - Sunday: 24h
        </p>
      </div>
    </div>
  </div>
@endsection
