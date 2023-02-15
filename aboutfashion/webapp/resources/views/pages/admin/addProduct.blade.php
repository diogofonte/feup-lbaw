@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h2 class="p-3 pb-5">Products</h2>
        </div>
        <div class="row">
            <div class="col-1">
                <a href="/admin-panel/products">
                    <i class="fa-solid fa-arrow-left fa-2x"></i>
                </a>
            </div>
            <div class="col">
                <h3>Add New Product</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <form method="POST" action="{{ route('storeProduct') }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="categorySelect" class="form-label"></label>
                        <select class="form-select" id="categorySelect" name="id_category">
                            <option>Select a category </option>
                            @foreach ($categories as $category)
                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                            @endforeach
                        </select>
                        <!-- Name -->
                        <label for="name" class="form-label mt-4">Name</label>
                        <input type="text" class="form-control" id="product_name" name="name">
                        <!-- Description -->
                        <label for="description" class="form-label mt-4">Description</label>
                        <input type="text" class="form-control" id="product_description" name="description">
                        <!-- Price -->
                        <label for="price" class="form-label mt-4">Price</label>
                        <input type="number" class="form-control" id="product_price" name="price">
                        <!-- Images -->
                        <label for="formFile" class="form-label mt-4">Images input</label>
                        <input required type="file" class="form-control" name="images[]" placeholder="images" multiple>
                    </div>
                    <div class="modal-footer p-5 pe-0">
                        <span class="error-text me-auto" style="color:red"> </span>
                        <button type="submit" class="btn btn-primary reg btn-lg">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
@endsection