@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h2 class="p-3 pb-5">Categories</h2>
        </div>
        <div class="row">
            <div class="col-1">
                <a href="/admin-panel/categories">
                    <i class="fa-solid fa-arrow-left fa-2x"></i>
                </a>
            </div>
            <div class="col">
                <h3>Add New Category</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <form method="POST" action="{{ route('storeCategory') }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <!-- Name -->
                        <label for="name" class="form-label mt-4">Name</label>
                        <input type="text" class="form-control" id="category_name" name="name">
                        <!-- Super Category -->
                        <label for="superCategorySelect" class="form-label"></label>
                        <select class="form-select" id="superCategorySelect" name="id_super_category">
                            <option value="">Select a mother category </option>
                            @foreach ($categories as $category)
                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer p-5 pe-0">
                        <span class="error-text me-auto" style="color:red"> </span>
                        <button type="submit" class="btn btn-primary reg btn-lg">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
@endsection