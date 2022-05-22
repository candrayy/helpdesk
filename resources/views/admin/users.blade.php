@extends('admin.layouts.app')
@section('title', 'Users - Helpdesk')
@section('content')

<!-- Isi Kontent -->
  <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 mt-2 mb-5">
                            <table class="table table-hover data-table" style="width: 100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Role</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>

            <div class="modal fade" id="ajaxModel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title" id="modelHeading"></h4>
                      </div>
                      <div class="modal-body">
                          <form id="roleDataForm" name="roleDataForm" class="form-horizontal">
                              <input type="hidden" name="id" id="id">
                              <div class="form-group">
                                  <label for="name" class="col-sm-2 control-label">Role</label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="role_id" name="role_id" readonly>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="name" class="col-sm-2 control-label">Name</label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="name" name="name" readonly>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="name" class="col-sm-2 control-label">Email</label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="email" name="email" readonly>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="name" class="col-sm-2 control-label">Status</label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="status" name="status" required>
                                  </div>
                              </div>
                
                              <div class="col-sm-offset-2 col-sm-10 mt-2">
                                  <button type="submit" class="btn btn-primary" id="saveBtn">Create</button>
                              </div>
                          </form>
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
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'role_id', name: 'role_id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    // $('#createNewUser').click(function () {
    //     $('#saveBtn').val("create-disease");
    //     $('#id').val('');
    //     $('#roleDataForm').trigger("reset");
    //     $('#modelHeading').html("Create New Disease");
    //     $('#ajaxModel').modal('show');
    // });
    
    $('body').on('click', '.editUser', function () {
        var id = $(this).data('id');
        $.get("{{ route('users.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Edit Role");
            $('#saveBtn').val("edit-role");
            $('#ajaxModel').modal('show');
            $('#id').val(data.id);
            $('#role_id').val(data.role_id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#status').val(data.status);
        })
    });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#roleDataForm').serialize(),
            url: "{{ route('users.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#roleDataForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                $('#saveBtn').html('Create');
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
                $('#saveBtn').html('Create');
            }
        });
    });
    $('body').on('click', '.deleteUser', function (){
        var id = $(this).data("id");
        var result = confirm("Are You sure want to delete !");
        if(result){
            $.ajax({
                type: "DELETE",
                url: "{{ route('users.store') }}"+'/'+id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }else{
            return false;
        }
    });
});
</script>

@endsection