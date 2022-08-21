@extends('layouts.app')

@push('stylesheet')
<link rel="stylesheet" href="css/chart.min.css">
@endpush

@section('content')
<div class="dt-content">
    <!-- <div class="row">
      <div class="col-md-12">
        <div class="filter-toggle btn-group float-right">
          <div class="btn btn-primary data-btn" data-start_date="{{ date('Y-m-d') }}" data-end_date="{{ date('Y-m-d') }}">Today</div>
          <div class="btn btn-primary data-btn" data-start_date="{{ date('Y-m-d',strtotime('-7 day')) }}" data-end_date="{{ date('Y-m-d') }}">This Week</div>
          <div class="btn btn-primary data-btn active" data-start_date="{{ date('Y-m').'-01' }}" data-end_date="{{ date('Y-m-d') }}">This Month</div>
          <div class="btn btn-primary data-btn" data-start_date="{{ date('Y').'-01-01' }}" data-end_date="{{ date('Y').'-12-31' }}">This Year</div>
        </div>
      </div>
    </div> -->
    <!-- Grid -->
    <div class="row pt-5">

      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-primary align-items-center pt-5">
          <img src="images/sale.svg" alt="Sale" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="sale"></h4>
          <h2 class="text-white mt-1">Restaurant Item</h2>
        </div>
      </div>

      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-warning align-items-center pt-5">
        <img src="images/customer.svg" alt="Customer" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="purchase"></h4>
          <h2 class="text-white mt-1">Bakery</h2>
        </div>
      </div>

      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-success align-items-center pt-5">
        <img src="images/customer.svg" alt="Customer" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="profit"></h4>
          <h2 class="text-white mt-1">Room Service</h2>
        </div>
      </div>
      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-danger align-items-center pt-5">
        <img src="images/customer.svg" alt="Customer" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="expense"></h4>
          <h2 class="text-white mt-1">Cafe</h2>
        </div>
      </div>
      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-info align-items-center pt-5">
          <img src="images/customer.svg" alt="Customer" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="customer"></h4>
          <h2 class="text-white mt-1">Health Care</h2>
        </div>
      </div>
    </div>

    
    
  </div>
@endsection

@push('script')
<script src="js/chart.min.js"></script>

@endpush
