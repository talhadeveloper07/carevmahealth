@extends('admin.layouts.app')
@section('admin_content')


<div class="container-xxl flex-grow-1 container-p-y">

    <div class='row d-flex justify-content-center mt-5 align-items-center'>
        <div class="col-md-5 custom-title-col">
            <h4 class='mb-0 custom-page-title'>Employees</h4>
            <p>View, add, edit and delete employees details.</p>
        </div>
        <div class="col-md-5 text-end">
            <a href="{{ route('add.employee') }}" class='btn cstm-btn-link text-white'>Add</a>
        </div>
    </div>
    <div class="row d-flex justify-content-center mt-5 align-items-center">
        <div class="col-md-10">
            <div class="mb-3">
                <label for="status-filter">Employee Status</label>
                <select id="status-filter" class="form-control" style="width: 200px;">
                    <option value="">Select Status</option>    
                    <option value="">All</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{$status->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="custom-card-body">
                <table class="table table-bordered" id="employees-table">
                    <thead>
                        <tr>
                            <th>Emp #</th>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Shift</th>
                            <th>Timezone</th>
                            <th>Salary</th>
                            <th>Joining</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header p-3 bg-danger">
        <h5 class="modal-title text-white" id="deleteEmployeeModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete <strong id="employeeName"></strong>?
        <input type="hidden" id="employeeId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>


<script>
$(function() {
    var table = $('#employees-table').DataTable({
    processing: true,
    serverSide: true,
    dom: 'Bfrtip', // add buttons container
        buttons: [
            'csv',        // CSV export
            'excel',      // Excel expor
            'print'       // Print view
        ],
    ajax: {
        url: '{{ route("all.employees") }}',
        data: function(d) {
            d.status = $('#status-filter').val();
        }
    },
    columns: [
        { data: 'employee_code', name: 'employee_code' },
        { data: 'employee_info', name: 'employee_info' },
        { data: 'department', name: 'department' },
        { data: 'status', name: 'status' },
        { data: 'shift_type', name: 'shift_type' },
        { data: 'timezone', name: 'timezone' },
        { data: 'salary', name: 'salary' },
        { data: 'date_of_joining', name: 'date_of_joining' },
        { data: 'actions', name: 'actions', orderable: false, searchable: false },
    ]
    });

    // Redraw on filter change
    $('#status-filter').change(function() {
        table.draw();
    });

});

$(document).ready(function () {
    let deleteId = null;

    // Open modal on delete button click
    $(document).on("click", ".delete-employee", function () {
        deleteId = $(this).data("id");
        let name = $(this).data("name");
        $("#employeeName").text(name);
        $("#deleteEmployeeModal").modal("show");
    });

    // Confirm delete
    $("#confirmDelete").click(function () {
        if (deleteId) {
            $.ajax({
                url: "/admin/employees/" + deleteId, // matches your route
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function (res) {
                    $("#deleteEmployeeModal").modal("hide");

                    if (res.success) {
                        $('#employees-table').DataTable().ajax.reload();
                    } else {
                        alert('something went wrong');
                    }
                },
                error: function (err) {
                    $("#deleteEmployeeModal").modal("hide");
                    toastr.error("Failed to delete employee");
                    console.error(err.responseJSON);
                }
            });
        }
    });
});


</script>


@endsection