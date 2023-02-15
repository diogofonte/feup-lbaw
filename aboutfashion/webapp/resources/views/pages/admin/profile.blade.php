@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row pt-3">
            <h2>Personal Information</h2>
        </div>
        <div class="row pt-4">
            <div id="personalInfo">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Role
                        <span>{{ $admin['role'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Social title
                        <span>{{ $admin['gender']==='M'? 'Mr.' : ($admin['gender']==='F'? 'Ms.' : 'Not Defined')}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        First name
                        <span>{{ $admin['first_name'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Second name
                        <span>{{ $admin['last_name'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Gender
                        @if (is_null($admin['gender']))
                            <span>Not Defined</span>
                        @elseif ($admin['gender'] == 'M')
                            <span>Male</span>
                        @elseif ($admin['gender'] == 'F')
                            <span>Female</span>
                        @else
                            <span>Other</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Email
                        <span>{{ $admin['email'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Birth Date
                        <span>{{ substr($admin['birth_date'], 0, 10) }}</span>
                    </li>
                </ul>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Profile Picture</h5>
                    </div>
                    <img src={{ $admin->image->file }} id="profilePic" width="300px" height="300px" />
                </div>
            </div>
        </div>
    </div>
@endsection