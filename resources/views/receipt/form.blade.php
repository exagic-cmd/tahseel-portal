@extends('layouts.app')

@section('css')
<style>
    .btn{
        border: 1px solid;
    background: gray;
    color: white;
    }
    #printableArea {
            /* padding: 20px;
            border: 1px solid #000;
            width: 80%;
            margin: 20px auto;
            background: #f8f8f8; */
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
                  <li class="breadcrumb-item"><a href="#">Receipts</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add Receipt</li>
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
            <div class="row g-4">
              <div class="col-md-6">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Receipt View</div></div>
                  <!--end::Header-->
                  <div class="card-body">
                  <div class="ticket receipt-view" id="printableArea">
        <img class="barcode hidden" id="barcode1" src="{{ asset('barcode.png') }}" alt="barcode">
            <img class="logo" src="{{ asset('logo.png') }}" alt="Logo">
            <p class="centered" style="margin-top: 10px;margin-bottom:3px; font-weight: 500"><b>حكومة الشارقة</b>
                <br>ه‍ينة ا لطرق و المواصلات دالرة ا لما لية المركزية
                <br>  نظام التعرفة المرورية للشاحنات   &nbsp;&nbsp;&nbsp;  نظا م تحصيل
                </p>
                <p style="margin-top: 0;text-align: right;padding-right:52px;height:2px" id="titleTop">
                </p>
                <p class="centered" style="height: 0px;font-family: auto;">(Payment Receipt)</p>
                <p class="centered" style="height: 3px; font-family: auto;">Tax Invoice / فاتورة قضريبية
                </p>
                <p class="centered" style="height: 3px;font-family: auto;">TRN: <span id="trn"></span></p>
            <table>
                <tbody>
                <tr>
                        <td class="description" style="direction:rtl" id="tim"></td>
                        <td class="description"style="width: 1px;">:الوقت</td>
                        <td class="description" style="width: 114px;" >&nbsp;&nbsp;&nbsp;:التاريخ<span style="font-size:13px;padding-right: 5px;" id="dte"></span></td>
                    </tr>
                    <tr>
                        <td class="description" colspan="3" >رقم الايصال:&nbsp;&nbsp;<span id="amt"></span></td>
           
                    </tr>
                    <tr>
                        <td class="description" colspan="3"><span>نوع لخدمة:&nbsp;&nbsp;&nbsp;&nbsp;</span>رسوم عبور شاحنة مع مقطورة</td>
                   
                    </tr>
                    <tr>
                        <td class="description" colspan="3">&nbsp;&nbsp;اسم المالك :&nbsp;<span id="vName"></span>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="description" colspan="3" ><span id="vNo"style="display: inline-block;"></span>&nbsp;&nbsp;&nbsp;&nbsp;:رقم المركبة</td>
                    </tr>
                    <tr>
                        <td class="description"  colspan="2"><span class="pdL33">درهم&nbsp;&nbsp;<span id="tAmt" style="display: inline-block;"></span></span></td>
                        <td class="description" colspan="1"><span></span>:اجمالى المبلغ </td>
                    </tr>
                    <tr>
                        <td class="quantity" colspan="1">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="description" colspan="2">رسوم اخرى</td>
                    </tr>
                    <tr>
                         <td class="quantity" colspan="1">درهم&nbsp;&nbsp;<span id="temAmt" style="display: inline-block;"></span></td>
                        <td class="description" colspan="2"><p style="font-size:12px; margin:0">:دعم الا بحات العلمية فى امارة الشارقة</p></td>
                    </tr>
                    <tr>
                         <td class="quantity" colspan="1">درهم&nbsp;&nbsp;<span id="charAmt" style="display: inline-block;"></span></td>
                        <td class="description" colspan="2">:رسوم خدمت تحصيل</td>
                    </tr>
                    <tr>
                         <td class="quantity"colspan="1">درهم&nbsp;&nbsp;<span id="lstAmt" style="display: inline-block;"></span></td>
                        <td class="description" colspan="2">:رسوم طرمية النيمة المضا فة</td>
                    </tr>
                </tbody>
            </table>
            <p class="centered" style="height: 3px;font-family: auto;"> Gate<span id="gNo"></span>:اسم لستخدم</p>
            <p class="centered" style="height: 3px; font-size: 12px"> ملاحظه:   ير جى لا حنفاظ يايصال تحصيل ندواعى امية</p>
             <!-- <img class="barcode" style="height:auto; width:130px"  src="{{ asset('qr-n-1.png') }}" alt="barcode"> -->
             <div id="receiptDisplay" class="ticket hidden"></div>
             <button id="btnPrint" class="hidden-print btn btn-default" onclick="printDiv('printableArea')">Print</button>
             
              <!-- <button id="btnPrintBar" class="hidden-print" onclick="myFunction()">Print with barcode</button> -->
        </div>
                </div>
                </div>
                <!--end::Quick Example-->
                
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-md-6">
                <!--begin::Different Height-->
                <div class="card card-secondary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Form</div></div>
                  <!--end::Header-->
                  <!--begin::Body-->
                  <div class="card-body">
                  <div class="frm hidden-print">
                    <form id="receiptForm">
                        @csrf
                        <ul class="form-style-1">
                            <li><label>Entity</label>
                            <input type="text" value="Sharjah Roads & Transporation Authority" name="entity" class="field-long">
                            </li>
                            <li><label>Reference No</label>
                            <input type="text" value="RTA52929483" name="refno" class="field-long">
                            </li>
                            <li><label>Application No</label>
                            <input type="text" value="C224819JU196K" name="appno" class="field-long">
                            </li>
                            <li><label>بوابة </label>
                                <input value="بوابة المدام" type="text" name="gate" id="titleT" class="field-long" /></li>
                            <li><label>TRN:</label>
                                <input value="100531353900003" type="text" name="trn" id="textone" class="field-long" /></li>
                            <li><label>:تاريخ</label>
                                <input type="date" value="{{ date('Y-m-d') }}" name="date" id="text3" class="field-long" /></li>
                            <li><label>:الوقت</label>
                                <input type="text" name="time" id="text4" value="16:01" class="field-long" /></li>
                            <li><label>:رقم الايصال</label>
                                <input value="3406191220210976" type="text" name="receipt_number" id="textTWO" class="field-long" /></li>
                            <li><label>:اسم المالك</label>
                                <input value="اسم المالك" type="text" name="owner_name" id="text55" class="field-long" /></li>
                            <li><label>:رقم المركبة</label>
                                <input value="Dubai(DXB)27827" type="text" name="vehicle_number" id="text5" class="field-long" /></li>
                            <li><label>:اجمالى المبلغ</label>
                                <input value="420.50"type="text" name="total_amount" id="text6" class="field-long" /></li>
                            <li><label>:دعم الا بحات العلمية فى امارة الشارقة</label>
                                <input value="10.2" type="text" name="research_support" id="text7" class="field-long" /></li>
                            <li><label>رسوم خدمت تحصيل</label>
                                <input value="10.2" type="text" name="collection_fee" id="text8" class="field-long" /></li>
                            <li><label>رسوم ضر يبة ا لقيمة المضا فة</label>
                                <input value="0.50" type="text" name="vat" id="text9" class="field-long" /></li>
                            <li><label>اسم لمستخدم</label>
                                <input value="3m" type="text" name="user_name" id="text10" class="field-long" /></li>
                            <li>
                                <button type="submit" class="btn">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                  </div>
                  <!--end::Body-->
                </div>
                <!--end::Different Height-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->

    
    

    <!-- Display Area for Receipt -->
    <!-- <div id="receiptDisplay" class="ticket">
    </div> -->
@stop
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#receiptForm').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission
        let formData = $(this).serialize(); // Get form data

                // Update Receipt Preview Immediately
                $('#titleTop').text($('#titleT').val());
                $('#trn').text($('#textone').val());
                $('#dte').text($('#text3').val());
                $('#tim').text($('#text4').val());
                $('#amt').text($('#textTWO').val());
                $('#vName').text($('#text55').val());
                $('#vNo').text($('#text5').val());
                $('#tAmt').text($('#text6').val());
                $('#temAmt').text($('#text7').val());
                $('#charAmt').text($('#text8').val());
                $('#lstAmt').text($('#text9').val());
                $('#gNo').text($('#text10').val());
        $.ajax({
            url: "{{ route('receipt.save') }}",
            method: "POST",
            data: $(this).serialize(),
             success: function (response) {
                        // Update the receipt display area with the new values
                        $('#receiptDisplay').html(response.receipt).removeClass('hidden');
                    },
            error: function (xhr) {
                console.log(xhr.responseText); // Log the error
                alert('An error occurred. Please check the console for details.');
            }
        });
    });
});

    </script>
    <script>
        function printDiv(divId) {
            var printContent = document.getElementById(divId).innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
           // location.reload(); // Reload page to restore content
        }
    </script>