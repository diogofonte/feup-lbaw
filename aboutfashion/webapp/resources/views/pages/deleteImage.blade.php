@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('deleteImage')}}" enctype="multipart/form-data">
  @csrf
  <!-- form elements go here -->
  Image ID:
  <input type="number" name="id">
  <button type="submit">Delete</button>
</form>

@endsection
