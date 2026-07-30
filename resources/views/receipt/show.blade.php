@extends('layouts.app')

@section('css')
<style>
  .btn{
        border: 1px solid;
    background: gray;
    color: white;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('content')
<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Detail Receipt</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
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
                    <div class="card-title">Receipt Detail</div>
                  </div>
                  <!--end::Header-->
                  <div class="ticket show card-body" id="printableArea" dir="rtl" lang="ar">
                      <!-- Top Logo -->
                      <div class="text-center mb-2">
                          <img class="receipt-logo" src="{{ asset('tahseel-logo.png') }}" alt="Tahseel Logo" style="width: 150px; height: auto; display: block; margin: 0 auto;">
                      </div>
                      
                      <hr class="receipt-divider">

                      <!-- Header Text Section (Centered RTL) -->
                      <div class="header-section text-center">
                          <div class="gov-title">حكومة الشارقة</div>
                          <div class="dept-row">
                              <span>دائرة المالية المركزية</span>
                              <span>هيئة الطرق والمواصلات</span>
                          </div>
                          <div class="dept-row">
                              <span>نظام الدفع الرقمي تحصيل</span>
                              <span>نظام التعرفة المرورية للشاحنات</span>
                          </div>
                          <div class="gate-title">{{ $receipt->gate }}</div>
                      </div>

                      <hr class="receipt-divider">

                      <!-- Sub-Header -->
                      <div class="subheader-section text-center">
                          <div class="payment-title">(Payment Receipt)</div>
                          <div class="tax-title">فاتورة ضريبية / Tax Invoice</div>
                          <div class="trn-title">TRN: <span id="trn">{{ $receipt->trn }}</span></div>
                      </div>

                      <!-- Details Section -->
                      <div class="details-section">
                          <!-- Date & Time Row -->
                          <div class="detail-row flex-between">
                              <div>التاريخ : <span id="dte">{{ $receipt->date }}</span></div>
                              <div>الوقت: <span id="tim">{{ $receipt->time }}</span></div>
                          </div>

                          <!-- Receipt Number -->
                          <div class="detail-row">
                              رقم الإيصال : <span id="amt" class="fw-bold">{{ $receipt->receipt_number }}</span>
                          </div>

                          <!-- Service Type -->
                          <div class="detail-row">
                              نوع الخدمة : <span>{{ $receipt->service_type ?? 'رسوم عبور شاحنة مع مقطورة نقدي' }}</span>
                          </div>

                          <!-- Owner Name -->
                          <div class="detail-row">
                              اسم المالـك : <span id="vName">{{ $receipt->owner_name }}</span>
                          </div>

                          <!-- Vehicle Number & Country -->
                          <div class="detail-row flex-between">
                              <div>رقم المركبة : <span id="vNo">{{ $receipt->vehicle_number }}</span></div>
                              @if(!empty($receipt->country))
                                  <div class="country-name">{{ $receipt->country }}</div>
                              @elseif(!empty($receipt->vehicle_country))
                                  <div class="country-name">{{ $receipt->vehicle_country }}</div>
                              @endif
                          </div>

                          <!-- Total Amount -->
                          <div class="detail-row flex-between">
                              <div>إجمالي المبلغ : <span id="tAmt">{{ $receipt->total_amount }}</span></div>
                              <div>درهم</div>
                          </div>

                          <!-- Other Fees Header -->
                          <div class="detail-row section-subtitle fw-bold mt-2">
                              رسوم أخرى :
                          </div>

                          <!-- Research Fee -->
                          <div class="detail-row flex-between sub-fee">
                              <div>دعم الأبحاث العلمية في إمارة الشارقة</div>
                              <div><span id="temAmt">{{ $receipt->research_support }}</span> درهم</div>
                          </div>

                          <!-- Collection Fee -->
                          <div class="detail-row flex-between sub-fee">
                              <div>رسم خدمة تحصيل</div>
                              <div><span id="charAmt">{{ $receipt->collection_fee }}</span> درهم</div>
                          </div>

                          <!-- VAT Fee -->
                          <div class="detail-row flex-between sub-fee">
                              <div>رسم ضريبة القيمة المضافة</div>
                              <div><span id="lstAmt">{{ $receipt->vat }}</span> درهم</div>
                          </div>

                          <!-- User / Operator -->
                          <div class="detail-row mt-2">
                              اسم المستخدم : <span id="gNo">{{ $receipt->user_name }}</span>
                          </div>

                          <!-- Note -->
                          <div class="detail-row note-text text-center mt-3">
                              <span class="fw-bold">ملاحظة :</span> يرجى الإحتفاظ بإيصال تحصيل لدواعي أمنية
                          </div>
                      </div>

                      <!-- QR Code -->
                      <div id="qrCode" class="qrCode text-center mt-3">
                          {!! $qrCode !!}
                      </div>
                      <div class="text-center mt-3">
                          <button id="btnPrint" class="hidden-print btn btn-default" onclick="printDiv('printableArea')">Print</button>
                      </div>
                  </div>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->

@stop

<script>
        function printDiv(divId) {
            var printContent = document.getElementById(divId).innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            document.body.style.overflow = "hidden"; // Prevents scrolling issues
    document.body.style.height = "auto"; // Ensures content fits
            window.print();
            document.body.innerHTML = originalContent;
           // location.reload(); // Reload page to restore content
        }
    </script>