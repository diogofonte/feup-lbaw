@extends('layouts.app')

@section('content')
    <script type="text/javascript" src={{ asset('js/create_review.js') }} defer></script>
    <div id="edit_form">
        <legend>Create Review</legend>
        <form method="POST" action="{{ route('reviewCreate') }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="productSelect" class="form-label mt-4"></label>
                <select class="form-select" id="productSelect" name="id_product">
                    <option data-img="">Select a product </option>
                    @foreach ($products as $product)
                        <option value="{{ $product['id'] }}" data-img="{{ $product->images[0]['file'] }}">
                            {{ $product['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="max-width: 20em;">
                <label for="review_title" class="form-label mt-4"></label>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Product</h5>
                    </div>
                    <img src="" id="productImg">
                </div>
            </div>
            <div class="form-group">
                <label for="review_title" class="form-label mt-4">Title</label>
                <input type="text" class="form-control" id="review_title" placeholder="Title" name="title">
            </div>
            <div class="form-group">
                <label for="description" class="form-label mt-4">Description</label>
                <input type="text" class="form-control" id="description" placeholder="Description" name="description">
            </div>
            <div class="form-group">
                <label for="description" class="form-label mt-4">Evaluation</label>
            </div>
            <div class="evaluation" id="input">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="evaluation" value="{{ $i }}" />
                    <label for="star{{ $i }}" title="text">{{ $i }} stars</label>
                @endfor
            </div>
            <div class="modal-footer">
                <span class="error-text me-auto" style="color:red"> </span>
                <button type="submit" class="btn btn-primary reg">Save</button>
            </div>
        </form>
    </div>
@endsection
