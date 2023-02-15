@extends('layouts.admin')

@section('content')
    @csrf
    <script type="text/javascript" src={{ asset('js/users_admin.js') }} defer></script>
    <div class="container">
        <div class="row">
            <h2 class="p-3 pb-5">Users</h2>
        </div>
        <!--<div class="row">
            <div class="col-6"></div>
            <div class="col-6 pb-3">
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>-->
        <div class="row">
            <div class="accordion" id="accordion">
                @foreach ($users as $user)
                    <div class="accordion-item" id="accordion-item-{{ $user->id }}">
                        <h2 class="accordion-header" id="heading-{{ $user->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $user->id }}" aria-expanded="true"
                                aria-controls="collapse-{{ $user->id }}">
                                <div class="col-1 pe-3">
                                    <img src="{{ asset($user->photo->imageURL()) }}" alt="user photo" class="img-fluid">
                                </div>
                                @if ($user->blocked == 1)
                                    <div class="col">
                                        {{ $user['first_name'] . ' ' . $user['last_name'] }}
                                        <span class="badge bg-danger ms-3"
                                            id="badge-block-{{ $user->id }}">Blocked</span>
                                    </div>
                                @else
                                    <div class="col">
                                        {{ $user['first_name'] . ' ' . $user['last_name'] }}
                                        <span class="badge bg-danger ms-3" id="badge-block-{{ $user->id }}"
                                        style="display: none">Blocked</span>
                                    </div>
                                @endif
                            </button>
                        </h2>
                        <div id="collapse-{{ $user->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading-{{ $user->id }}" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col">
                                        <strong>E-mail:</strong> {{ $user['email'] }}
                                        <br>
                                        <strong>Birth date:</strong>
                                        {{ isset($user['birth_date']) ? substr($user['birth_date'], 0, 10) : 'Not Defined' }}
                                        <br>
                                        <strong>Gender:</strong>
                                        @if (is_null($user['gender']))
                                            Not Defined
                                        @elseif ($user['gender'] == 'M')
                                            Male
                                        @elseif ($user['gender'] == 'F')
                                            Female
                                        @else
                                            Other
                                        @endif
                                    </div>
                                    <div class="col-1">
                                        <div class="row">
                                            <a type="submit" class="btn btn-secondary btn-sm mb-3"
                                                href="{{ route('userPurchaseHistoryAdminPanel', ['id' => $user->id]) }}">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </a>
                                        </div>
                                        @if (Auth::guard('admin')->user()->role == 'Technician')
                                            @if ($user['blocked'] == 0)
                                                <div class="row">
                                                    <button class="btn btn-warning btn-sm mb-3 fa-solid fa-lock block-user"
                                                        id="block-{{ $user->id }}">
                                                    </button>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <button
                                                        class="btn btn-warning btn-sm mb-3 fa-solid fa-unlock block-user"
                                                        id="block-{{ $user->id }}">
                                                    </button>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <button
                                                    class="fa-solid fa-user-xmark btn btn-danger btn-sm pe-1 delete-user"
                                                    id={{ $user->id }}>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="padding-top:1em;">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
