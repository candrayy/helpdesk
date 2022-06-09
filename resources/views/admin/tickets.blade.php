@extends('admin.layouts.app')
@section('title', 'Tickets - Helpdesk')
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
                                        <th>User</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Due On</th>
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
        ajax: "{{ route('ticketss.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'user_id', name: 'user_id'},
            {data: 'picture', name: 'picture', orderable: false},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'assigned_to', name: 'assigned_to'},
            {data: 'status', name: 'status'},
            {data: 'due_on', name: 'due_on'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    /*$('#createNewUser').click(function () {
        $('#saveBtn').val("create-disease");
        $('#id').val('');
        $('#roleDataForm').trigger("reset");
        $('#modelHeading').html("Create New Disease");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editTicket', function () {
        var id = $(this).data('id');
        $.get("{{ route('tickets.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Edit Role");
            $('#saveBtn').val("edit-role");
            $('#ajaxModel').modal('show');
            $('#id').val(data.id);
            $('#user_id').val(data.user_id);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('#assigned_to').val(data.assigned_to);
            $('#status').val(data.status);
            $('#due_on').val(data.due_on);
        })
    });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#roleDataForm').serialize(),
            url: "{{ route('tickets.store') }}",
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
                url: "{{ route('tickets.store') }}"+'/'+id,
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
    });*/
});
</script>

@endsection