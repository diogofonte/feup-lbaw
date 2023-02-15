@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('editImage')}}" enctype="multipart/form-data">
    @csrf
    <!-- form elements go here -->
    Image ID:
    <input type="number" name="id">
    Image file:
    <input type="file" name="image">
    <button type="submit">Edit</button>
  </form>
  
@endsection
