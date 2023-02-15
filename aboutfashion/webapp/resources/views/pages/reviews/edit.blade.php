@extends('layouts.app')

@section('content')
    <div id="edit_form">
        <legend>Edit Review</legend>
        <form method="POST" action="{{ route('reviewUpdate', ['id' => $review->id]) }}">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="review_title" class="form-label mt-4">Title</label>
                <input type="text" class="form-control" id="review_title" value="{{$review->title}}" name="title">
            </div>
            <div class="form-group">
                <label for="description" class="form-label mt-4">Description</label>
                <input type="text" class="form-control" id="description" value="{{$review->description}}" name="description">
            </div>
            <div class="form-group">
                <label for="description" class="form-label mt-4">Evaluation</label>
            </div>
            <div class="evaluation" id="input">
                @for($i = 5; $i >= 1; $i--)
                    @if ($review['evaluation']===$i)
                        <input type="radio" id="star{{$i}}" name="evaluation" value="{{$i}}" checked/>
                    @else
                        <input type="radio" id="star{{$i}}" name="evaluation" value="{{$i}}" />
                    @endif
                    <label for="star{{$i}}" title="text">{{$i}} stars</label>
                @endfor
            </div>
            <div class="modal-footer">
                <span class="error-text me-auto" style="color:red"> </span>
                <button type="submit" class="btn btn-primary reg">Save</button>
            </div>
        </form>
    </div>
@endsection