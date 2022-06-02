@extends('admin.layouts.app')
@section('title', 'Admin - Helpdesk')
@section('content')

<!-- Isi Konten -->

  <div class="row mx-auto">
    <div class="col-sm">
      <div class="card shadow-sm p-3 mb-5 bg-body border-primary">
        <div class="card-body">
          <h5 class="card-title">Tickets</h5>
          <button type="button" class="btn btn-primary mt-2" disabled>{{ $ticket }}</button>
        </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card shadow-sm p-3 mb-5 bg-body border-success">
        <div class="card-body">
        <h5 class="card-title">Comment</h5>
          <button type="button" class="btn btn-primary mt-2" disabled>{{ $comment }}</button>
        </div>
      </div>
    </div>
  </div>

<!-- End Konten -->

@endsection