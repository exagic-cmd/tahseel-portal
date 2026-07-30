<div id="receipt-content">
	<div class="pdf-receipt">
        <div class="ticket show card-body" dir="rtl" lang="ar">
            <!-- Top Logo -->
            <div class="text-center mb-2">
                <img class="receipt-logo" src="{{ asset('tahseel-logo.png') }}" alt="Tahseel Logo" style="width: 150px; height: auto; display: block; margin: 0 auto;">
            </div>
            
            <hr class="receipt-divider">

            <!-- Header Text Section (Centered RTL) -->
            <div class="header-section text-center">
                <div class="gov-title">حكومة الشارقة</div>
                <div class="dept-row">
                    <span>هيئة الطرق والمواصلات</span>
                    <span>دائرة المالية المركزية</span>                    
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
            <div class="qrCode text-center mt-3">
                @if(!empty($data['qrimage']))
                    <img src="{{ $data['qrimage'] }}" alt="QR Code" style="width: 140px; height: 140px; display: block; margin: 0 auto;">
                @elseif(!empty($qrCode))
                    {!! $qrCode !!}
                @endif
            </div>
        </div>
	</div>
</div>