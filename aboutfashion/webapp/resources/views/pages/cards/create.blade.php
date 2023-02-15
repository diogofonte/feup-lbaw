@extends('layouts.app')

@section('content')
    <div id="edit_form">
        <legend>Create Card</legend>
        <form method="POST" action="{{ route('cardCreate') }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="nick_name" class="form-label mt-4">Nick Name</label>
                <input type="text" class="form-control" id="nickname" placeholder="Nick Name" name="nickname">
            </div>
            <div class="form-group">
                <label for="name" class="form-label mt-4">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
            </div>
            <div class="form-group">
                <label for="number" class="form-label mt-4">Number</label>
                <input type="text" class="form-control" id="number" placeholder="Number" name="number" required>
            </div>
            <div class="form-group">
                <div class=" me-auto"></div>
                <label for="month" class="form-label mt-4">Month:</label>
                <input type="number" id="month" class="form-control" name="month" placeholder="Month" required>
            </div>
            <div class="form-group">
                <div class=" me-auto"></div>
                <label for="year" class="form-label mt-4">Year:</label>
                <input type="number" id="year" class="form-control" name="year" placeholder="Year" required>
            </div>
            <div class="form-group">
                <label for="code" class="form-label mt-4">Code</label>
                <input type="text" class="form-control" id="code" placeholder="Code" name="code" required>
            </div>
            <div class="modal-footer">
                <span class="error-text me-auto" style="color:red"> </span>
                <button type="submit" class="btn btn-primary reg">Save</button>
            </div>
        </form>

    </div>
@endsection
