@extends('layouts.app')

@section('content')
<div class="profile-flex">
    <ul id="profile-tab" class="nav nav-pills flex-column" role="tablist" >
        <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#information" aria-selected="false" role="tab"
                tabindex="-1">Information</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#addresses" aria-selected="true" role="tab">Addresses</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#orders" aria-selected="true" role="tab">Orders, History and
                Details</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#reviews" aria-selected="true" role="tab">Reviews</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#cards" aria-selected="true" role="tab">Cards</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade show active" id="information" role="tabpanel">
            <h2>Personal Information</h2>
            <div id="personalInfo">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Social title
                        <span>{{ $user['gender']==='M'? 'Mr.' : ($user['gender']==='F'? 'Ms.' : 'Other')}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        First name
                        <span>{{ $user['first_name'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Second name
                        <span>{{ $user['last_name'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Gender
                        @if (is_null($user['gender']))
                            <span>Not Defined</span>
                        @elseif ($user['gender'] == 'M')
                            <span>Male</span>
                        @elseif ($user['gender'] == 'F')
                            <span>Female</span>
                        @else
                            <span>Other</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Email
                        <span>{{ $user['email'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Birth Date
                        <span>{{ substr($user['birth_date'], 0, 10) }}</span>
                    </li>
                </ul>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title d-flex justify-content-between">Profile Picture
                            <div class="justify-content-between" style="display: flex; flex-direction: row; align-items: center;">
                                <a class="fas fa-edit" href="{{ url('/editPicture') }}" data-bs-toggle="modal" data-bs-target="#editPicture"></a>
                                <form action="{{ route('deletePicture', ['id' => $user->id]) }}" method="post">
                                    <input class="btn btn-danger btn-sm" type="submit" value="Delete" style="margin-left: 1em;"> </input>
                                    @method('delete')
                                    @csrf
                                </form>
                            </div>
                        </h5>
                    </div>
                    <img src="{{ asset($user->photo->imageURL()) }}" id="profilePic" width="300px" height="300px" />
                </div>
            </div>
            <div class="bottom_buttons">
                <a class="btn btn-primary" href="{{ url('/users/1/edit') }}" role="button"> Edit profile </a>
                <form action="{{ url('/users', ['id' => $user['id']]) }}" method="post">
                    <input class="btn btn-danger" type="submit" value="Delete Profile" />
                    @method('delete')
                    @csrf
                </form>
            </div>
            <div class="modal fade" id="editPicture" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">New Profile Picture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('editPicture', ['id' => $user['id']]) }}" enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                <div class="form-group">
                                    <label for="formFile" class="form-label mt-4">Picture input file</label>
                                    <input class="form-control" type="file" id="formFile" name="image">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="addresses" role="tabpanel">
            <h2>My Addresses</h2>
            <a class="btn btn-primary add_item" href="{{ route('addressCreateForm') }}" role="button">Add Address</a>
            <div class="cards_flex">
                @foreach ($user->addresses as $address)
                    <div class="card border-primary mb-3" style="max-width: 23rem;">
                        <div class="card-header">Name: {{ isset($address['name']) ? $address['name'] : 'Not Defined' }}
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Company
                                    <span>{{ isset($address['company']) ? $address['company'] : 'Not Defined' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    NIF
                                    <span>{{ isset($address['nif']) ? $address['nif'] : 'Not Defined' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Country
                                    <span>{{ isset($address['id_country']) ? $countries[$address['id_country']]['name'] : 'Not Defined' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Street
                                    <span>{{ isset($address['street']) ? $address['street'] : 'Not Defined' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Number
                                    <span>{{ isset($address['number']) ? $address['number'] : 'Not Defined' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Apartment
                                    <span>{{ isset($address['apartment']) ? $address['apartment'] : 'Not Defined' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Note
                                    <span>{{ isset($address['note']) ? $address['note'] : 'Not Defined' }}</span>
                                </li>
                            </ul>
                            <div class="bottom_buttons">
                                <a class="btn btn-primary" href={{ route('addressEditForm', ['id' => $address['id']]) }}
                                    role="button"> Edit Address</a>
                                <form action="{{ route('addressDelete', ['id' => $address['id']]) }}" method="post">
                                    <input class="btn btn-danger" type="submit" value="Delete Address" />
                                    @method('delete')
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="orders" role="tabpanel">
            <h2>My Orders</h2>
            <div class="cards_flex">
                @foreach ($user->orders as $order)
                    @if($order['status'] == 'Shopping Cart')
                    @else
                    <div class="card border-primary mb-3" style="max-width: 23rem;">
                        <div class="card-header">Order #{{ $order['id'] }}</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Date
                                    <span>{{ substr($order['date'], 0, 10) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Status
                                    <span class="badge bg-primary">{{ $order['status'] }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Address Name
                                    <span>{{ isset($order['address']['name']) ? $order['address']['name'] : 'Not Defined' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Card Number
                                    <span>{{ isset($order['card']['number']) ? $order['card']['number'] : 'Not Defined' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Products
                                    <span>
                                        @foreach ($order->details as $detail)
                                            {{ $detail->product['name'] }} <br>
                                        @endforeach
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Price
                                    <span>{{ $order->totalPrice($order['id']) }}</span>
                                </li>
                            </ul>
                            <a href="/order/{{ $order['id'] }}" class="card-link ms-2 me-5">More Details</a>
                            @if($order['status'] == 'Shopping Cart' || $order['status'] == 'Completed' || $order['status'] == 'Cancelled')
                            @else
                            <button class="btn btn-danger ms-5" style="align-items: flex-end;"><a href="/orders/{{ $order['id'] }}/cancel" style="color:#fff;text-decoration: none;" class="card-link">Cancel Order</a></button>
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            <h2>My Reviews</h2>
            <a class="btn btn-primary add_item" href="{{ route('reviewCreateForm') }}" role="button">New Review</a>
            <div class="cards_flex">
                @foreach ($user->reviews as $review)
                    <div class="card border-primary mb-3" style="max-width: 25rem;">
                        <div class="card-header">Review #{{ $review['id'] }}</div> 
                        <div class="card-body">
                            <h4 class="card-title d-flex justify-content-between align-items-center">{{ $review['title'] }}
                                <div> {{count($review->like)}} <span class="far fa-thumbs-up"></span></div>
                            </h4>
                            <p class="text-muted"> 
                                <i class="fas fa-quote-left pe-2" aria-hidden="true"></i>
                                {{ $review['description']}} </p>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Product
                                    <span>
                                        <a href="/products/{{ $review->product['id'] }}" class="card-link">
                                            {{ ucwords(strtolower($review->product['name'])) }}
                                        </a>
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Evaluation
                                    <ul class="list-unstyled d-flex justify-content-center text-warning mb-0">
                                    @for ($i = 1; $i <= $review['evaluation']; $i++)
                                        <li><i class="fas fa-star fa-sm" aria-hidden="true"></i></li>
                                    @endfor
                                    @for ($i = $review['evaluation']; $i < 5; $i++)
                                        <li><i class="far fa-star fa-sm" aria-hidden="true"></i></li>
                                    @endfor
                                    </ul>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Date
                                    <span>{{ substr($review['date'], 0, 10) }}</span>
                                </li>
                            </ul>
                            <div class="bottom_buttons">
                                <a class="btn btn-primary" href={{ route('reviewEditForm', ['id' => $review['id']]) }} role="button"> 
                                    Edit Review
                                </a>
                                <form action="{{ route('reviewDelete', ['id' => $review['id']]) }}" method="post">
                                    <input class="btn btn-danger" type="submit" value="Delete Review" />
                                    @method('delete')
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="cards" role="tabpanel">
            <h2>My Cards</h2>
            <a class="btn btn-primary add_item" href="{{ route('cardCreateForm') }}" role="button">Add Card</a>
            <div class="cards_flex">
                @foreach ($user->cards as $card)
                    <div class="card border-primary mb-3" style="max-width: 23rem;">
                        <div class="card-header">Card #{{ $card['number'] }}</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Nick name
                                    <span>{{ $card['nickname'] }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Name
                                    <span>{{ $card['name'] }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Month/Year
                                    <span>{{ $card['month'] }}/{{ $card['year'] }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Code
                                    <span>{{ $card['code'] }}</span>
                                </li>
                            </ul>
                            <div class="bottom_buttons">
                                <a class="btn btn-primary" href={{ route('cardEditForm', ['id' => $card['id']]) }}
                                    role="button"> Edit
                                    Card </a>
                                <form action="{{ route('cardDelete', ['id' => $card['id']]) }}" method="post">
                                    <input class="btn btn-danger" type="submit" value="Delete Card" />
                                    @method('delete')
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
