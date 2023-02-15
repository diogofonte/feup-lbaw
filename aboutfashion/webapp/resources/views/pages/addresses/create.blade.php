@extends('layouts.app')

@section('content')
    <div id="edit_form">
        <legend>Create Address</legend>
        <form method="POST" action="{{ route('addressCreate') }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="address_name" class="form-label mt-4">Address Name</label>
                <input type="text" class="form-control" id="address_name" placeholder="Address Name" name="name" required>
            </div>
            <div class="form-group">
                <label for="company" class="form-label mt-4">Company</label>
                <input type="text" class="form-control" id="company" placeholder="Company" name="company">
            </div>
            <div class="form-group">
                <label for="nif" class="form-label mt-4">NIF</label>
                <input type="text" class="form-control" id="nif" placeholder="NIF" name="nif">
            </div>
            <div class="form-group">
                <label for="exampleSelect1" class="form-label mt-4">Select Country</label>
                <select class="form-select" id="exampleSelect1" name="id_country" required>
                    <option>Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country['id'] }}" name='id_country'>{{ $country['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="street" class="form-label mt-4">Street</label>
                <input type="text" class="form-control" id="street" placeholder="Street" name="street" required>
            </div>
            <div class="form-group">
                <label for="number" class="form-label mt-4">Number</label>
                <input type="number" class="form-control" id="number" placeholder="Number" name="number" required>
            </div>
            <div class="form-group">
                <label for="apartment" class="form-label mt-4">Apartment</label>
                <input type="text" class="form-control" id="apartment" placeholder="Apartment" name="apartment" required>
            </div>
            <div class="form-group">
                <label for="note" class="form-label mt-4">Note</label>
                <input type="text" class="form-control" id="note" placeholder="Note" name="note">
            </div>
            <div class="modal-footer">
                <span class="error-text me-auto" style="color:red"> </span>
                <button type="submit" class="btn btn-primary reg">Save</button>
            </div>
        </form>
    </div>
@endsection
