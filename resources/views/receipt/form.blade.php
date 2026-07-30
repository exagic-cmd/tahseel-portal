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
<link rel="stylesheet" href="{{ asset('css/receipt-print.css') }}">
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
                  <div class="tahseel-receipt" id="printableArea">
                    <div class="header-barcode">
                        <img id="barcode1" src="{{ asset('barcode-print.png') }}" alt="barcode">
                    </div>

                    <div class="header-logos">
                        <div class="gov-logo-box">
                            <img src="{{ asset('government-logo.png') }}" alt="Government Logo">
                        </div>
                        <div class="tahseel-logo-box">
                            <img src="{{ asset('tahseel-logo.png') }}" alt="Tahseel Logo">
                        </div>
                    </div>

                    <div class="titles-flex-container">
                        <div class="header-text-side header-text-left">
                            <p>حكومة الشارقة</p>
                            <p>هيئة الطرق والمواصلات</p>
                            <p>نظام التعرفة المرورية للشاحنات</p>
                        </div>
                        <div class="titles-section">
                            &nbsp;
                        </div>
                        <div class="header-text-side header-text-right">
                            <p>حكومة الشارقة</p>
                            <p>دائرة المالية المركزية</p>
                            <p>نظام الدفع الرقمي تحصيل</p>
                        </div>
                    </div>
                    <div class="titles-flex-container">
                        <div class="header-text-side header-text-left">
                            &nbsp;
                        </div>
                        <div class="titles-section">
                            <p class="tax-invoice-title-arb">فاتورة ضريبية</p>
                            <p class="tax-invoice-title-eng">Tax Invoice</p>
                            <p class="trn-text">TRN <span id="trn"></span></p>
                        </div>
                        <div class="header-text-side header-text-right">
                            &nbsp;
                        </div>
                    </div>
                    <div class="title-separator"></div>

                    <table class="data-table">
                        <tbody>
                            <tr class="time-date-row">
                                <td colspan="3">
                                    <div class="time-date-container">
                                        <div style="width: 45%; display: flex; justify-content: space-between;">
                                            <span class="col-eng">Time</span>
                                            <span class="col-val" id="tim"></span>
                                            <span class="col-arb">الوقت</span>
                                        </div>
                                        <div style="width: 45%; display: flex; justify-content: space-between;">
                                            <span class="col-eng">Date</span>
                                            <span class="col-val" id="dte"></span>
                                            <span class="col-arb">التاريخ</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-eng">Receipt number</td>
                                <td class="col-val" id="rcptNo"></td>
                                <td class="col-arb">رقم الإيصال</td>
                            </tr>
                            <tr>
                                <td class="col-eng">Amount</td>
                                <td class="col-val" id="tAmt"></td>
                                <td class="col-arb">المبلغ</td>
                            </tr>
                            <tr>
                                <td class="col-eng">Owner Name</td>
                                <td class="col-val" id="vName"></td>
                                <td class="col-arb">إسم المالك</td>
                            </tr>
                            <tr>
                                <td class="col-eng">Service</td>
                                <td class="col-val">رسوم عبور شاحنة مع مقطورة</td>
                                <td class="col-arb">نوع الخدمة</td>
                            </tr>
                            <tr>
                                <td class="col-eng">Vehicle Number</td>
                                <td class="col-val" id="vNo"></td>
                                <td class="col-arb">رقم المركبة</td>
                            </tr>
                            <tr>
                                <td class="col-eng">User Name</td>
                                <td class="col-val" id="gNo"></td>
                                <td class="col-arb">إسم المستخدم</td>
                            </tr>
                            <tr>
                                <td class="col-eng">Voucher Number</td>
                                <td class="col-val" id="voucherNo"></td>
                                <td class="col-arb">رقم الإيصال الإلكتروني</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="qrCode" id="receiptDisplay"></div>

                    <div class="footer-section print-only">
                        <div class="footer-meta">
                            <span id="footer_timestamp"></span>
                            <span id="footer_username"></span>
                        </div>
                        <div class="footer-row">
                            <table class="legal-table">
                                <tbody>
                                    <tr>
                                        <td class="footer-col-eng">This receipt has been printed based on the data entered in digital payment system Tahseel.</td>
                                        <td class="footer-col-arb">تمت طباعة هذا الإيصال اعتماداً على البيانات<br> المدخلة بنظام الدفع الرقمي تحصيل.</td>
                                    </tr>
                                    <tr>
                                        <td class="footer-col-eng">Photocopied or unsigned and unsealed receipts are not considered valid.</td>
                                        <td class="footer-col-arb">لا يعتد بالإيصالات المنسوخة أو غير الموقعة<br> والمختومة.</td>
                                    </tr>
                                    <tr>
                                        <td class="footer-col-eng">Any erasure or alteration in this document invalidates it.</td>
                                        <td class="footer-col-arb">كل كشط أو تغيير في هذه الوثيقة يلغيها.</td>
                                    </tr>
                                    <tr>
                                        <td class="footer-col-eng">Please verify receipt details by scanning QR code.</td>
                                        <td class="footer-col-arb">يرجى مطابقة بيانات الإيصال عن طريق مسح <br>رمز الاستجابة السريعة.</td>
                                    </tr>
                                    <tr>
                                        <td class="footer-col-eng">Please make sure after you scan QR code that the browser address is<br> tahseel.gov.ae</td>
                                        <td class="footer-col-arb">يرجى التأكد بعد مسح رمز الاستجابة السريعة<br> أن عنوان المتصفح هو tahseel.gov.ae</td>
                                    </tr>
                                    <tr>
                                        <td class="footer-col-eng">To review the approved fees, please refer to Executive Council Decision No. 10 for the year 2022.</td>
                                        <td class="footer-col-arb">لمراجعة الرسوم المعتمدة يرجى مراجعة<br> قرار المجلس التنفيذي رقم 10 لسنة 2022.</td>
                                    </tr>
                                    <tr>
                                        <td class="footer-col-eng">Please keep the receipt for auditing purposes.</td>
                                        <td class="footer-col-arb">يرجى الاحتفاظ بالإيصال لدواعي التدقيق.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <button id="btnPrint" class="hidden-print btn btn-default" onclick="printDiv('printableArea')">Print</button>
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
                            <li><label>رقم الإيصال الإلكتروني</label>
                                <input value="7346438296276560" type="text" name="voucher_number" id="textVoucher" class="field-long" /></li>
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
                let rawDate = $('#text3').val();
                let formattedDate = rawDate ? rawDate.split("-").reverse().join("/") : "";
                let timeVal = $('#text4').val();
                let userName = $('#text10').val();

                $('#trn').text($('#textone').val());
                $('#dte').text(formattedDate);
                $('#tim').text(timeVal);
                $('#rcptNo').text($('#textTWO').val());
                $('#voucherNo').text($('#textVoucher').val());
                $('#vName').text($('#text55').val());
                $('#vNo').text($('#text5').val());
                $('#tAmt').text($('#text6').val());
                $('#gNo').text(userName);
                $('#footer_timestamp').text(formattedDate + ' ' + timeVal);
                $('#footer_username').text(userName);
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
            var printContent = document.getElementById(divId).outerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
           // location.reload(); // Reload page to restore content
        }
    </script>