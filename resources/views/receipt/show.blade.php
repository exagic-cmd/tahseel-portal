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
                  <div class="ticket show card-body" id="printableArea">
                      <img class="barcode hidden" id="barcode1" src="{{ asset('barcode.png') }}" alt="barcode">
                      <img class="logo" src="{{ asset('logo.png') }}" alt="Logo">
                      <p class="centered" style="margin-top: 10px;margin-bottom:3px; font-weight: 500">حكومة الشارقة
                          <br>ه‍ينة ا لطرق و المواصلات دالرة ا لما لية المركزية
                          <br>  نظام التعرفة المرورية للشاحنات   &nbsp;&nbsp;&nbsp;  نظا م تحصيل
                      </p>
                      <p style="margin-top: 0;text-align: right;padding-right:52px;height:2px" id="titleTop">
                          {{ $receipt->gate }}
                      </p>
                      <p class="centered" style="height: 0px;font-family: auto;">(Payment Receipt)</p>
                      <p class="centered" style="height: 3px; font-family: auto;">Tax Invoice / فاتورة قضريبية
                      </p>
                      <p class="centered" style="height: 3px; font-family: auto;">TRN: <span id="trn">{{ $receipt->trn }}</span></p>
                      <table>
                          <tbody>
                              <tr>
                                  <td class="description" style="direction:rtl" id="tim">{{ $receipt->time }}</td>
                                  <td class="description"style="width: 1px;">:الوقت</td>
                                  <td class="description" style="width: 114px;" >&nbsp;&nbsp;&nbsp;:التاريخ<span style="font-size:13px;padding-right: 5px;" id="dte">{{ $receipt->date }}</span></td>
                              </tr>
                              <tr>
                                  <td class="description" colspan="3" >رقم الايصال:&nbsp;&nbsp;<span id="amt">{{ $receipt->receipt_number }}</span></td>
                              </tr>
                              <tr>
                                  <td class="description" colspan="3"><span>نوع لخدمة:&nbsp;&nbsp;&nbsp;&nbsp;</span>رسوم عبور شاحنة مع مقطورة</td>
                              </tr>
                              <tr>
                                  <td class="description" colspan="3">&nbsp;&nbsp;اسم المالك :&nbsp;<span id="vName">{{ $receipt->owner_name }}</span>&nbsp;</td>
                              </tr>
                              <tr>
                                  <td class="description" colspan="3" ><span id="vNo"style="display: inline-block;">{{ $receipt->vehicle_number }}</span>&nbsp;&nbsp;&nbsp;&nbsp;:رقم المركبة</td>
                              </tr>
                              <tr>
                                  <td class="description"  colspan="2"><span class="pdL33">درهم&nbsp;&nbsp;<span id="tAmt" style="display: inline-block;"> {{ $receipt->total_amount }}</span></span></td>
                                  <td class="description" colspan="1"><span></span>:اجمالى المبلغ </td>
                              </tr>
                              <tr>
                                  <td class="quantity" colspan="1">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                  <td class="description" colspan="2">رسوم اخرى</td>
                              </tr>
                              <tr>
                                  <td class="quantity" colspan="1">درهم&nbsp;&nbsp;<span id="temAmt" style="display: inline-block;">{{ $receipt->research_support }}</span></td>
                                  <td class="description" colspan="4"><p style="font-size:12px; margin:0">:دعم الا بحات العلمية فى امارة الشارقة</p></td>
                              </tr>
                              <tr>
                                  <td class="quantity" colspan="1">درهم&nbsp;&nbsp;<span id="charAmt" style="display: inline-block;">{{ $receipt->collection_fee }}</span></td>
                                  <td class="description" colspan="4">:رسوم خدمت تحصيل</td>
                              </tr>
                              <tr>
                                  <td class="quantity"colspan="1">درهم&nbsp;&nbsp;<span id="lstAmt" style="display: inline-block;">{{ $receipt->vat }}</span></td>
                                  <td class="description" colspan="4">:رسوم طرمية النيمة المضا فة</td>
                              </tr>
                          </tbody>
                      </table>
                      <p class="centered" style="height: 3px;font-family: auto;"> Gate<span id="gNo">{{ $receipt->user_name }}</span>:اسم لستخدم</p>
                      <p class="centered" style="height: 3px; font-size: 12px"> ملاحظه:   ير جى لا حنفاظ يايصال تحصيل ندواعى امية</p>
                      <div id="qrCode" class="barcode" >
                      {!! $qrCode !!}
                  </div>
                <button id="btnPrint" class="hidden-print btn btn-default" onclick="printDiv('printableArea')">Print</button>
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