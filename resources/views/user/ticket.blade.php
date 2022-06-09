@extends('user.layouts.app')
@section('title', 'Ticket - Helpdesk')
@section('content')

<!-- Isi Kontent -->
<!-- add -->
            <div class="modal fade" id="addTicketModal" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title" id="modelHeading">Add New Ticket</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <form method="POST" id="addTicketForm" name="addTicketForm" class="form-horizontal" enctype="multipart/form-data">
                              {{ csrf_field() }}
                              <input type="hidden" name="id" id="id">
                              <div class="form-group">
                                  <div class="col-sm-12">
                                      <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" required>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="img_ticket" class="col-sm-2 control-label">Image</label>
                                  <div class="col-sm-12">
                                      <input type="file" class="form-control" name="picture" required>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="name" class="col-sm-2 control-label">Title</label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="title" name="title" required>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="name" class="col-sm-2 control-label">Description</label>
                                  <div class="col-sm-12">
                                  <textarea type="text" id="description" name="description" class="form-control desc" required></textarea>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="name" class="col-sm-2 control-label">Assigned To</label>
                                  <div class="col-sm-12">
                                    <select name="assigned_to" id="assigned_to" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        @foreach($dataUsers as $du)
                                            <option value="{{$du->id}}">{{$du->name}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <div class="col-sm-12">
                                      <label for="status" class="col-sm-2 control_label">Status</label>
                                      <input type="text" class="form-control" id="status" name="status" value="Open" readonly>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="name" class="col-sm-2 control-label">Due On</label>
                                  <div class="col-sm-12">
                                      <input type="date" class="form-control" id="due_on" name="due_on" required>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="addTicket" class="btn btn-primary">Add Ticket</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
            </div>
<!-- end add -->

<!-- edit -->
            <div class="modal fade" id="editTicketModal" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title" id="modelHeading">Edit Ticket</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <form method="POST" id="editTicketForm" name="editTicketForm" class="form-horizontal" enctype="multipart/form-data">
                              {{ csrf_field() }}
                              <input type="hidden" name="tkt_id" id="tkt_id">
                              <input type="hidden" name="tkt_picture" id="tkt_picture">
                              <div class="form-group">
                                  <div class="col-sm-12">
                                      <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" required>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="picture" class="col-sm-2 control-label">Image</label>
                                  <div class="col-sm-12">
                                      <input type="file" class="form-control" id="picture" name="picture">
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="name" class="col-sm-2 control-label">Title</label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="title" name="title" required>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="name" class="col-sm-2 control-label">Description</label>
                                  <div class="col-sm-12">
                                  <textarea type="text" id="description" name="description" class="form-control desc" required></textarea>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="name" class="col-sm-2 control-label">Assigned To</label>
                                  <div class="col-sm-12">
                                    <select name="assigned_to" id="assigned_to" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        @foreach($dataUsers as $du)
                                            <option value="{{$du->id}}">{{$du->name}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <div class="col-sm-12">
                                      <label for="status" class="col-sm-2 control_label">Status</label>
                                      <input type="text" class="form-control" id="status" name="status" value="Open" readonly>
                                  </div>
                              </div>
                              <div class="form-group mb-3">
                                  <label for="name" class="col-sm-2 control-label">Due On</label>
                                  <div class="col-sm-12">
                                      <input type="date" class="form-control" id="due_on" name="due_on" required>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="editTicket" class="btn btn-primary">Edit Ticket</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
            </div>
<!-- end edit -->

    <div class="container">
        <div class="row my-5">
        <div class="col-lg-12">
            <div class="card shadow">
            <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                <h3 class="text-light">Manage Ticket</h3>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addTicketModal"><i
                    class="bi-plus-circle me-2"></i>Add New Ticket</button>
            </div>
            <div class="card-body" id="showAllTicket">
                <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>
            </div>
        </div>
        </div>
    </div>


  <script type="text/javascript">
    $(function () {
     
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // add new ticket ajax request
    $("#addTicket").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addTicket").text('Adding...');
        $.ajax({
          url: '{{ route('tickets.store') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Student Added Successfully!',
                'success'
              )
              fetchAllTicket();
            }
            $("#addTicket").text('Add Ticket');
            $("#addTicketForm")[0].reset();
            $("#addTicketModal").modal('hide');
          }
        });
      });
     

    // edit student ajax request
    $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('editTkt') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#user_id").val(response.user_id);
            $("#title").val(response.title);
            $("#description").val(response.description);
            $("#assigned_to").val(response.assigned_to);
            $("#status").val(response.status);
            $("#due_on").val(response.due_on);
            $("#picture").html(
              `<img src="storage/images/${response.picture}" width="100" class="img-fluid img-thumbnail">`);
            $("#tkt_id").val(response.id);
            $("#tkt_picture").val(response.picture);
          }
        });
      });

      // update student ajax request
      $("#editTicketForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#editTicket").text('Updating...');
        $.ajax({
          url: '{{ route('updateTkt') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Student Updated Successfully!',
                'success'
              )
              fetchAllTicket();
            }
            $("#editTicket").text('Update Ticket');
            $("#editTicketForm")[0].reset();
            $("#editTicketModal").modal('hide');
          }
        });
      });

      // delete student ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('deleteTkt') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllTicket();
              }
            });
          }
        })
      });


    // fetch all ticket ajax request
    fetchAllTicket();

    function fetchAllTicket() {
    $.ajax({
        url: '{{ route('fetchAll') }}',
        method: 'get',
        success: function(response) {
            $("#showAllTicket").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
    }

});
</script>

<script src="//cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>
<script>
    //CKEDITOR.replaceClass = 'desc';
</script>

@endsection