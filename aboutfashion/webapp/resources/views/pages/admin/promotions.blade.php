@extends('layouts.admin')

@section('content')
    @csrf
    <script type="text/javascript" src={{ asset('js/promotion_admin.js') }} defer></script>
    <div class="container">
        <div class="row">
            <h2 class="p-3">Promotions</h2>
        </div>
        <div class="row mb-5">
            <div class="col-2">
                <a type="button" class="btn btn-outline-primary mb-4" href="{{ route('createPromotion') }}">
                    <i class="fa-solid fa-plus"></i>
                    Add Promotion
                </a>
            </div>
            <div class="col-10"></div>
            <!--<div class="col-4"></div>
            <div class="col-6">
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>-->
            <div class="accordion" id="accordion">
                @foreach ($promotions as $promotion)
                    <div class="accordion-item" id="accordion-item-{{ $promotion->id }}">
                        <h2 class="accordion-header" id="heading{{ $promotion->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $promotion->id }}" aria-expanded="true"
                                aria-controls="collapse{{ $promotion->id }}">
                                <div class="col">
                                    <strong>Promotion ID: </strong>{{ $promotion->id }}
                                    <br>
                                    <br>
                                    <strong>Discount: </strong>{{ $promotion->discount }} %
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $promotion->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $promotion->id }}" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col">
                                        <strong>Start Date: </strong>{{ substr($promotion['start_date'], 0, 10) }}
                                        <br>
                                        <strong>Final Date: </strong>{{ substr($promotion['final_date'], 0, 10) }}
                                    </div>
                                    @if (Auth::guard('admin')->user()->role == 'Collaborator')
                                        <div class="col-1">
                                            <div class="row">
                                                <a type="submit" class="btn btn-primary btn-sm mb-3"
                                                        href="{{ route('editPromotion', ['id' => $promotion->id]) }}">
                                                    <i class="fa-solid fa-pencil"></i>
                                                    &nbsp;
                                                    edit
                                                </a>
                                            </div>
                                            <div class="row">
                                                <button class="btn btn-danger btn-sm pe-1 fa-solid fa-xmark delete-promotion" 
                                                        id="{{ $promotion->id }}">    
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
                {{ $promotions->links() }}
            </div>
        </div>
    </div>
@endsection
