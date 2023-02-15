@extends('layouts.app')

@section('content')
  <form method="POST" action="{{route('uploadImage')}}" enctype="multipart/form-data">
    @csrf
    <!-- form elements go here -->
    <input type="file" name="image">
    <button type="submit">Upload</button>
  </form>
@endsection
