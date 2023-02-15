@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h2 class="p-3 pb-5">Promotions</h2>
        </div>
        <div class="row">
            <div class="col-1">
                <a href="/admin-panel/promotions">
                    <i class="fa-regular fa-arrow-left fa-2x"></i>
                </a>
            </div>
            <div class="col">
                <h3>Add New Promotion</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <form method="POST" action="{{ route('storePromotion') }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <!-- Discount -->
                        <label for="discount" class="form-label mt-4">Discount</label>
                        <input type="number" class="form-control" id="promotion_discount" name="discount">
                        <!-- Start Date -->
                        <label for="start_date" class="form-label mt-4">Start Date</label>
                        <input type="date" class="form-control" id="promotion_start_date" name="start_date">
                        <!-- Final Date -->
                        <label for="final_date" class="form-label mt-4">Final Date</label>
                        <input type="date" class="form-control" id="promotion_final_date" name="final_date">
                    </div>
                    <div class="modal-footer p-5 pe-0">
                        <span class="error-text me-auto" style="color:red"> </span>
                        <button type="submit" class="btn btn-primary reg btn-lg">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
@endsection