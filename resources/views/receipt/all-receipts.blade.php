@extends('layouts.app')


<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />

@section('content')

<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">All Receipts</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">All Receipts</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
<!-- Content Wrapper. Contains page content -->
  <div class="app-content">
   

    <!-- Main content -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Receipts</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                   @php $counter = 1; @endphp
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>بوابة</th>
                    <th>TRN</th>
                    <th>تاريخ</th>
                    <th>الوقت</th>
                   <!-- <th>رقم الايصال</th>-->
                    <th>اسم المالك</th>
                    <th>رقم المركبة</th>
                    <th>اجمالى المبلغ</th>
                    <!-- <th>دعم الا بحات العلمية فى امارة الشارقة</th>
                    <th>رسوم خدمت تحصيل</th>
                    <th>رسوم ضر يبة ا لقيمة المضا فة</th> -->
                    <th>اسم لمستخدم</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  	  @foreach($receipts as $receipt)
                  <tr>
                    <td>{{ $counter }}</td>
                <td>{{ $receipt->gate }}</td>
                <td>{{ $receipt->trn }}</td>
                <td>{{ $receipt->date }}</td>
                <td>{{ $receipt->time }}</td>
               <!-- <td>{{ $receipt->receipt_number }}</td>-->
                <td>{{ $receipt->owner_name }}</td>
                <td>{{ $receipt->vehicle_number }}</td>
                <td>{{ $receipt->total_amount }}</td>
                <!-- <td>{{ $receipt->research_support }}</td>
                <td>{{ $receipt->collection_fee }}</td>
                <td>{{ $receipt->vat }}</td> -->
                <td>{{ $receipt->user_name }}</td>
             
                    <td class="project-actions text-right">
                          <!-- <a class="btn btn-primary btn-sm" href="{{ $receipt->id }}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a> -->
                          <a class="btn btn-info btn-sm" href="{{ route('receipt.edit', $receipt->id) }}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                         
                          <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $receipt->id }}">Delete</button>
                </td>
                  </tr>
                   @php $counter++; @endphp
                  @endforeach



                  </tbody>
                  <tfoot>
                  <tr>
                    <th>S.No</th>
                    <th>بوابة</th>
                    <th>TRN</th>
                    <th>تاريخ</th>
                    <th>الوقت</th>
                   <!-- <th>رقم الايصال</th> -->
                    <th>اسم المالك</th>
                    <th>رقم المركبة</th>
                    <th>اجمالى المبلغ</th>
                   <!--  <th>دعم الا بحات العلمية فى امارة الشارقة</th>
                    <th>رسوم خدمت تحصيل</th>
                    <th>رسوم ضر يبة ا لقيمة المضا فة</th> -->
                    <th>اسم لمستخدم</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@stop

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
 <script>
    $(document).ready(function () {
        $(".delete-btn").on("click", function () {
            var receiptId = $(this).data("id");

            if (confirm("Are you sure you want to delete this receipt?")) {
                $.ajax({
                    url: "/receipt/" + receiptId,
                    type: "POST",  // Change from DELETE to POST
                    data: {
                        _method: "DELETE", // Laravel requires this for DELETE requests
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $("#receipt-" + receiptId).remove(); // Remove row from table
                        alert(response.success);
                       location.reload();
                    },
                    error: function () {
                        alert("An error occurred while deleting the receipt.");
                    }

                });
            }
        });
    });
</script>
