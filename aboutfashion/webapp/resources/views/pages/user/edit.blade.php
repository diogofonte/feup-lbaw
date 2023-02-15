@extends('layouts.app')

@section('content')
    <div id="edit_form">
        <legend>Edit Profile</legend>

        <form method="POST" action="{{ route('userUpdate', ['id' => $user['id']]) }}">
            {{ csrf_field() }}
            @method('PATCH')
            <div class="form-group">
                <label for="first_name" class="form-label mt-4">First Name</label>
                <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name">
            </div>
            <div class="form-group">
                <label for="last_name" class="form-label mt-4">Last Name</label>
                <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name">
            </div>
            <div class="form-group">
                <label for="email1" class="form-label mt-4">Email address</label>
                <input id="email1" type="text" name="email" autofocus class="form-control"
                    placeholder="Enter email">
                @if ($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" id="password1" placeholder="Password" name="password">
            </div>
            <div class="form-group">
                <label for="password" class="form-label mt-4">Confirm Password</label>
                <input type="password" class="form-control" id="password2" placeholder="Password" name="password">
            </div>

            <div class="form-group">
                <div class=" me-auto"></div>
                <label for="gender" class="form-label mt-4">Gender</label>
                <select class="form-select" name="gender">
                    <option value="P">Option in my profile - {{ $user->gender }}</option>
                    <option value="B">Blank</option>
                    <option value="F">Female</option>
                    <option value="M">Male</option>
                    <option value="O">Other</option>
                </select>
            </div>
            <div class="form-group">
                <div class=" me-auto"></div>
                <label for="birthdate" class="form-label mt-4">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate">
            </div>
            <div class="modal-footer">
                <span class="error-text me-auto" style="color:red"> </span>
                <button type="submit" class="btn btn-primary reg">Save</button>
            </div>
        </form>

    </div>
@endsection
