@extends('layouts.app')


@section('content')

<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard.</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->

<!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-primary">
                  <div class="inner">
                    <h3>{{ $receiptCount }}</h3>
                    <p>Total Receipts</p>
                  </div>
                  <a
                    href="{{route('all-receipts')}}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Show all <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 1-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3>{{ $todayReceiptCount }}</h3>
                    <p>Today's Receipts</p>
                  </div>
                  <a
                    href="{{route('all-receipts')}}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Show all <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 2-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                  <div class="inner">
                    <h3>{{$totalAmount}} AED</h3>
                    <p>Total Amount</p>
                  </div>
                  <a
                    href="#"
                    class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    More info <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 3-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 4-->
                <div class="small-box text-bg-danger">
                  <div class="inner">
                    <h3>{{$todayTotalAmount}} AED</h3>
                    <p>Today's Total Amount</p>
                  </div>
                  <a
                    href="#"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    More info <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 4-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row">
              <!-- /.col -->
              <div class="col-md-12">                
                <!-- /.card -->
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Today's All Receipts</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table table-striped">
                      <thead>
                      @php $counter = 1; @endphp
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>بوابة</th>
                          <th>TRN</th>
                          <th>الوقت</th>
                          <th>رقم الايصال</th>
                          <th>اسم المالك</th>
                          <th>رقم المركبة</th>
                          <th>اجمالى المبلغ</th>
                          <th>اسم لمستخدم</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($todayReceipts as $receipt)
                        <tr class="align-middle">
                          <td>{{ $counter }}.</td>
                          <td>{{$receipt->gate}}</td>
                          <td>{{$receipt->trn}}</td>
                          <td>{{$receipt->time}}</td>
                          <td>{{$receipt->receipt_number}}</td>
                          <td>{{$receipt->owner_name}}</td>
                          <td>{{$receipt->vehicle_number}}</td>
                          <td>{{$receipt->total_amount}}</td>
                          <td>{{$receipt->user_name}}</td>
                        </tr>
                        @php $counter++; @endphp
                        @endforeach
                        @if ($todayReceipts->isEmpty())
                            <p class="text-muted text-center">No receipts found for today.</p>
                        @endif
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
        






@stop