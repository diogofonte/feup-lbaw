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
                <h3>Edit Informations of {{ $product['name'] }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <form method="POST" action="{{ route('updateProduct', ['id' => $product->id]) }}">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4 pt-4">
                                <div class="card">
                                    <img src="{{ asset($product->images[0]->imageURL()) }}" alt="product image" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-1"></div>
                            <div class="col">
                                <!-- Category -->
                                <label for="categorySelect" class="form-label mt-4">Category</label>
                                <select class="form-select" id="categorySelect" name="id_category" value="{{$product['id_category']}}" onchange="showCategory()"> <!-- ATENÇÃO AO ONCHANGE -->
                                    <option value="{{ $product['id_category'] }}" selected>{{ $product->category->name }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                                    @endforeach
                                </select>
                                <!-- Name -->
                                <label for="name" class="form-label mt-4">Name</label>
                                <input type="text" class="form-control" id="product_name" value="{{$product->name}}" name="name">
                                <!-- Description -->
                                <label for="description" class="form-label mt-4">Description</label>
                                <input type="text" class="form-control" id="product_description" value="{{$product->description}}" name="description">
                                <!-- Price -->
                                <label for="price" class="form-label mt-4">Price (€)</label>
                                <input type="number" class="form-control" id="product_price" value="{{$product->price}}" name="price">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-5 pe-0">
                        <span class="error-text me-auto" style="color:red"> </span>
                        <button type="submit" class="btn btn-primary reg btn-lg">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row pb-3">
            <h3>Edit images</h3>
        </div>
        <div class="row pb-5">
            <div class="col" style="display: flex; flex-wrap: wrap;">
                @foreach ($product->images as $image)
                <div class="card mb-3" style="margin: 1em;">
                    <div class="card-header">
                        <h7 class="card-title d-flex justify-content-between">Image #{{$image->id}}
                            <div class="justify-content-between" style="display: flex; flex-direction: row; align-items: center;">
                                <a class="fas fa-edit" href="{{ url('/editProductImage'.$image->id) }}" data-bs-toggle="modal" data-bs-target="#editProductImage{{$image->id}}"></a>
                                @if(count($product->images)>1)
                                <form action="{{ route('deleteProductImage', ['id_image' => $image->id, 'id_product' => $product->id]) }}" method="post">
                                    <input class="btn btn-danger btn-sm" type="submit" value="Delete" style="margin-left: 1em;"> </input>
                                    @method('delete')
                                    @csrf
                                </form>
                                @endif
                            </div>
                        </h7>
                    </div>
                    <img src="{{ asset($image->imageURL()) }}" id="productImage" style="object-fit:contain; width:250px; height:auto;"/>
                </div>
                <div class="modal fade" id="editProductImage{{$image->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Product Image #{{$image->id}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('editProductImage', ['id_image' => $image->id, 'id_product' => $product->id]) }}" enctype="multipart/form-data">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="formFile" class="form-label mt-4">Product Image file</label>
                                        <input class="form-control" type="file" id="formFile" name="image">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-1">
                <span class="error-text me-auto" style="color:red"> </span>
                <button class="btn btn-primary reg" href="{{ url('/addProductImage') }}" data-bs-toggle="modal" data-bs-target="#addProductImage">Add Image</button>
            </div>
            <div class="modal fade" id="addProductImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Product Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('addProductImage', ['id_product' => $product->id]) }}" enctype="multipart/form-data">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="formFile" class="form-label mt-4">New Product Image file</label>
                                        <input class="form-control" type="file" id="formFile" name="image">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="col-1"></div>
        </div>
        <div class="row pb-3">
            <h3>Edit promotions</h3>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Final Date</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->promotions as $promotion)
                            <tr>
                                <th scope="row">{{$promotion->id}}</th>
                                <td>{{$promotion->discount}} %</td>
                                <td>{{$promotion->start_date}}</td>
                                <td>{{$promotion->final_date}}</td>
                                <td>
                                    <form method="POST" action="{{ route('removeProductPromotion', ['id' => $product->id]) }}">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="id_promotion" value="{{$promotion->id}}">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
            <div class="col">
                <form method="POST" action="{{ route('addProductPromotion', ['id' => $product->id]) }}">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <!-- Promotions -->
                        <label for="promotionSelect" class="form-label mt-4">Promotions</label>
                        <select class="form-select" id="promotionSelect" name="id_promotion" onchange="showPromotion()"> <!-- ATENÇÃO AO ONCHANGE -->
                            <option>Select a new promotion to apply</option>
                            @foreach ($promotions as $promotion)
                                @php
                                    $formatStartDate = date('Y-m-d', strtotime($promotion->start_date));
                                    $formatFinalDate = date('Y-m-d', strtotime($promotion->final_date));
                                @endphp
                                <option value="{{$promotion['id']}}">{{$promotion['discount']}} %, starts: {{$formatStartDate}}, ends: {{$formatFinalDate}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer p-5 pe-0">
                        <span class="error-text me-auto" style="color:red"> </span>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row pb-5">
            <h3>Manage Stock</h3>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Color</th>
                            <th scope="col">Size</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->stocks as $stock)
                            <tr>
                                <th scope="row">{{$stock->color->name}}</th>
                                <td>{{$stock->size->name}}</td>
                                <td>
                                    <form method="POST" action="{{ route('modifyProductStock', ['id' => $product->id]) }}">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="id_color" value="{{$stock->color->id}}">
                                        <input type="hidden" name="id_size" value="{{$stock->size->id}}">
                                        <div class="row">
                                            <div class="col">
                                                <input type="number" class="form-control" id="product_stock_{{$stock->id_color}}_{{$stock->id_size}}"
                                                value="{{$stock->stock}}" name="new_stock">
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-2"></div>
            <div class="col">
                <h4 class="pb-3">Add new stock</h4>
                <form method="POST" action="{{ route('addNewProductStock', ['id' => $product->id]) }}">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <!-- Color -->
                        <label for="colorSelect" class="form-label">Color</label>
                        <select class="form-select" id="colorSelect" name="id_color">
                            <option>Select a color</option>
                            @foreach ($colors as $color)
                                <option value="{{$color['id']}}">{{$color['name']}}</option>
                            @endforeach
                        </select>
                        <!-- Size -->
                        <label for="sizeSelect" class="form-label">Size</label>
                        <select class="form-select" id="sizeSelect" name="id_size">
                            <option>Select a size</option>
                            @foreach ($sizes as $size)
                                <option value="{{$size['id']}}">{{$size['name']}}</option>
                            @endforeach
                        </select>
                        <!-- Stock -->
                        <label for="quantitySelect" class="form-label mt-4">Quantity</label>
                        <input type="number" class="form-control" id="quantitySelect" name="new_stock">
                    </div>
                    <div class="modal-footer p-5 pe-0">
                        <span class="error-text me-auto" style="color:red"> </span>
                        <button type="submit" class="btn btn-primary btn-lg">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
@endsection