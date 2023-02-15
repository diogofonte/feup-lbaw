@extends('layouts.admin')

@section('content')
    @csrf
    <script type="text/javascript" src={{ asset('js/product_category.js') }} defer></script>
    <div class="container">
        <div class="row">
            <h2 class="p-3">Categories</h2>
        </div>
        <div class="row mb-5">
            <div class="col">
                <a type="button" class="btn btn-outline-primary mb-4" href="{{ route('createCategory') }}">
                    <i class="fa-solid fa-plus"></i>
                    Add Category
                </a>
            </div>
            <div class="accordion" id="accordion">
                @foreach ($categories as $category)
                    <div class="accordion-item" id="accordion-item-{{ $category->id }}">
                        <h2 class="accordion-header" id="heading{{ $category->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $category->id }}" aria-expanded="true"
                                aria-controls="collapse{{ $category->id }}">
                                <div class="col">
                                    <strong>Name: </strong>{{ $category->name }}
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $category->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $category->id }}" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col">
                                        @if (!is_null($category->id_super_category))
                                            <strong>Super Category: </strong>{{ $category->superCategory->name }}    
                                        @else
                                            <strong>Super Category: </strong>None
                                        @endif
                                    </div>
                                    @if (Auth::guard('admin')->user()->role == 'Collaborator')
                                        <div class="col-1">
                                            <div class="row">
                                                <button class="btn btn-danger btn-sm pe-1 fa-solid fa-xmark delete-category" 
                                                    id="{{ $category->id }}">
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
