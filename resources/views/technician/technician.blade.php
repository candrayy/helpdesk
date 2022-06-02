@extends('technician.layouts.app')
@section('title', 'Technician - Helpdesk')
@section('content')

<!-- Isi Kontent -->
<div class="d-flex justify-content-center mt-3">
    <div class="col-sm-6">
      <div class="card border-primary shadow-sm p-3 mb-5 bg-body">
        <div class="card-body">
          <h5 class="card-title mb-3">Ticket</h5>
          <a href="#" class="btn btn-primary">{{ $ticket }}</a>
        </div>
      </div>
    </div>
</div>
<!-- End Kontent -->

@endsection