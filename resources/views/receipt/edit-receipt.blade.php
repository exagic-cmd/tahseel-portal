@extends('layouts.app')

@section('css')

<style>
	.card-body{
		direction: ltr;
	}

</style>

@stop

@section('content')

<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Edit Receipts</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a>
                  <li class="breadcrumb-item active" aria-current="page">Edit 
                  Receipt
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row g-4">
              <!--begin::Col-->
              <div class="col-md-8">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header">
                  	<div class="card-title">Update the Fields</div>
                  </div>
                  <!--end::Header-->
                  <!--begin::Form-->
                  <form action="{{ route('receipt.update', $receipt->id) }}" method="POST">
                  	 @csrf
        			@method('PUT')
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                      	<label class="form-label">بوابة </label>
                    <input value="{{ $receipt->gate }}" type="text" name="gate" id="titleT" class="form-control" />
                <label class="form-label">TRN:</label>
                    <input value="{{ $receipt->trn }}" type="text" name="trn" id="textone" class="form-control" />
                <label class="form-label">:تاريخ</label>
                    <input value="{{ $receipt->date }}" type="date" name="date" id="text3" class="form-control" />
               <label class="form-label">:الوقت</label>
                    <input type="text" name="time" id="text4" value="{{ $receipt->time }}" class="form-control" />
                <label class="form-label">:رقم الايصال</label>
                    <input value="{{ $receipt->receipt_number }}" type="text" name="receipt_number" id="textTWO" class="form-control" />
                <label class="form-label">:اسم المالك</label>
                    <input value="{{ $receipt->owner_name }}"type="text" name="owner_name" id="text55" class="form-control" />
                <label class="form-label">:رقم المركبة</label>
                    <input value="{{ $receipt->vehicle_number }}" type="text" name="vehicle_number" id="text5" class="form-control" />
                <label class="form-label">:اجمالى المبلغ</label>
                    <input value="{{ $receipt->total_amount }}"type="text" name="total_amount" id="text6" class="form-control" />
                <label class="form-label">:دعم الا بحات العلمية فى امارة الشارقة</label>
                    <input value="{{ $receipt->research_support }}" type="text" name="research_support" id="text7" class="form-control" />
                <label class="form-label">رسوم خدمت تحصيل</label>
                    <input value="{{ $receipt->collection_fee }}" type="text" name="collection_fee" id="text8" class="form-control" />
                <label class="form-label">رسوم ضر يبة ا لقيمة المضا فة</label class="form-label">
                    <input value="{{ $receipt->vat }}" type="text" name="vat" id="text9" class="form-control" />
                <label class="form-label">اسم لمستخدم</label>
                    <input value="{{ $receipt->user_name }}" type="text" name="user_name" id="text10" class="form-control" />
                         


                      
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <!--end::Footer-->
                  </form>
                  <!--end::Form-->
                </div>
                <!--end::Quick Example-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->

@stop
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
	 $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
	$.ajax({
    url: "{{ route('receipt.update', $receipt->id) }}",
    type: "PUT",
    data: $('#updateForm').serialize(),
    success: function(response) {
        alert("Updated Successfully!");
    },
    error: function(xhr) {
        console.log(xhr.responseText);
    }
});

</script>