@extends('layouts.admin')

@section('content')
    @csrf
    <script type="text/javascript" src={{ asset('js/review_admin.js') }} defer></script>
    <div class="container">
        <div class="row">
            <h2 class="p-3 pb-5">Reviews</h2>
        </div>
        <div class="row mb-5">
            <!--<div class="col-6"></div>
            <div class="col-6 mb-3">
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>-->
            <div class="accordion" id="accordion">
                @foreach($reviews as $review)
                    <div class="accordion-item" id="accordion-item-{{ $review->id }}">
                        <h2 class="accordion-header" id="heading{{$review->id}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{$review->id}}" aria-expanded="true" 
                                    aria-controls="collapse{{$review->id}}">
                                <div class="col-1 pe-3">
                                    <img src="{{ asset($review->product->images[0]->imageURL()) }}" alt="product image" 
                                        class="img-fluid">
                                </div>
                                <div class="col">
                                    <strong>Review ID: {{ $review->id }}</strong>
                                    <br>
                                    <br>
                                    Product: {{ $review->product->name }}
                                    <br>
                                    <br>
                                    User: {{ $review->user['first_name'] . ' ' . $review->user['last_name'] }}
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{$review->id}}" class="accordion-collapse collapse" 
                            aria-labelledby="heading{{$review->id}}" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col">
                                        <strong>Evaluation:</strong> {{ $review->evaluation }}
                                        <br>
                                        <strong>Title:</strong> {{ $review->title }}
                                        <br>
                                        <strong>Description:</strong> {{ $review->description }}
                                        <br>
                                        <strong>Date:</strong> {{ substr($review['date'], 0, 10) }}
                                    </div>
                                    @if (Auth::guard('admin')->user()->role == 'Technician')
                                        <div class="col-1">
                                            <div class="row">
                                                <button class="btn btn-danger btn-sm pe-1 fa-solid fa-xmark delete-review" 
                                                    id="{{ $review->id }}">    
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="padding-top:1em;">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
@endsection