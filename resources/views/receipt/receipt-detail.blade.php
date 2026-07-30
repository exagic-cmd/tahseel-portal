<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahseel Digital Payment System</title>
	<link rel="icon" type="image/x-icon" href="{{asset('favicon.png')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Poppins:wght@300;400;600&display=swap">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/scan-style.css')}}" />
</head>
<body>
<div id="preloader">
        <img src="{{asset('favicon.png')}}" alt="Loading..." id="preloader-logo">
    </div>
	<div class="container-fluid g-0">
    <div class="hero ">
		<div class="container">
        <div class="navbar">
            <div class="logo">
				<img src="{{asset('logo-white.png')}}">
				
			</div>
			<div>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Tahseel</a></li>
                <li><a href="#">News & Events</a></li>				
                <li><a href="#">Login</a></li>
            </ul>
	</div>
            
			
        </div>
		<div class="menu-icon">
        <img src="{{asset('logo-white.png')}}">
            </div>
		<div>
			<h1>Tahseel Receipt Details</h1>
			<h5>Home / Tahseel Receipt Details</h5>
			</div>
		
	</div>
    </div>
    <div class="container">
	<div class="payment">
			<h2 class="text-dark mb-4">Payment Transaction</h2>
			<ul>
			<li class="text-warning mb-1 font-size-h6">Please check the below information with the paper receipt and below print receipt.</li>
			<li class="text-warning font-size-h6 mb-4">In case any mismatch information, please contact us on the toll free number - 8008247335
				</li>
			</ul>
			<div class="row">
				<div class="col-md-6">
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Entity : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->entity }} </label>
					<br>
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Reference No : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->refno }} </label>
					<br>
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Application No : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->appno }} </label>

				</div>
				<div class="col-md-6">

				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Receipt No : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->receipt_number }} </label>
					<br>
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Total Amount : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->total_amount }} AED</label>
					<br>
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Date : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->date }}T{{ $receipt->time }} </label>

				</div>
			</div>
			 
	


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
                    <span>نظام التعرفة المرورية للشاحنات</span>
                    <span>نظام الدفع الرقمي تحصيل</span>
                </div>
                <div class="gate-title">{{ $receipt->gate }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
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
	<iframe id="pdfViewer" width="100%" height="600px"></iframe>
   <div class="text-center">
    <button class="btn btn-primary text-center" onclick="openPDF()">Download Receipt <i class="fa-solid fa-print print-icon"></i></button>
    </div>
	</div>
    </div>
	<div id="loading" style="display: none;">Generating PDF...</div>
    <div class="mobile-nav">
    <div class="d-flex j-content">
        <div class="col-xs-4 text-center">
        <i class="fa-solid fa-house"></i>
        </div>
        <div class="col-xs-4 text-center">
            <img src="{{asset('favicon.png')}}"/>
        </div>
        <div class="col-xs-4 text-center">
        <i onclick="openMenu() " class="fa-solid fa-bars"></i>
        </div>
    </div>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <div class="close-menu" onclick="closeMenu()">&times;</div>
        <div class="tabs">
        <div class="tab active" onclick="openTab(event, 'overview')"><i class="fa-solid fa-user"></i></div>
        <div class="tab" onclick="openTab(event, 'posts')"><i class="fa-solid fa-gear"></i></div>
        <div class="tab" onclick="openTab(event, 'settings')"><i class="fa-solid fa-circle-exclamation"></i></div>
    </div>
    
    <div id="overview" class="tab-content active">
        <div class="d-flex">
        <i class="fa-solid fa-circle-user" style="font-size: 61px;margin-right: 9px;"></i>
        <h3>Hi, <br> Guest</h3>
        </div>
        <ul class="tabs-p">
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Login</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Forget username?</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Forget password?</li>
        </ul>
    </div>
    <div id="posts" class="tab-content">
        <h6>Select Background</h6>
        <div class="d-flex circle j-content">
            <img class="img-circle" src="{{asset('fog1.jpg')}}"/>
            <img src="{{asset('image1.jpg')}}"/>
            <img src="{{asset('image2.jpg')}}"/>
        </div>
    </div>
    <div id="settings" class="tab-content">
    <ul class="tabs-p">
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Home</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Services</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; News & Events</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Service Locations</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Our Features</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; FAQ's</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; About</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Terms & Conditions</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Open Ticket</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Followup Ticket</li>
        </ul>
    </div>
    </div>
    <script>
        function openMenu() {
            document.getElementById('mobileMenu').style.display = 'flex';
        }
        function closeMenu() {
            document.getElementById('mobileMenu').style.display = 'none';
        }
    </script>
	<script>
   async function generatePDF() {
        document.getElementById('loading').style.display = 'block';
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });
        doc.setProperties({
            title: 'Tahseel Receipt'
        });

        // Temporarily render receipt content for capturing
        const receiptContent = document.getElementById("receipt-content");
        const ticketElem = receiptContent.querySelector(".ticket") || receiptContent;
        
        receiptContent.style.position = 'fixed';
        receiptContent.style.left = '0';
        receiptContent.style.top = '0';
        receiptContent.style.visibility = 'visible';
        receiptContent.style.zIndex = '-9999';

        await html2canvas(ticketElem, { 
            scale: 3,
            logging: false,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff'
        }).then((canvas) => {
            const imgData = canvas.toDataURL("image/png");
            const pdfWidth = doc.internal.pageSize.getWidth();
            const imgWidth = 95; // Left-aligned 360px receipt width on PDF
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            const xPos = 10; // Left aligned
            const yPos = 10;

            doc.addImage(imgData, "PNG", xPos, yPos, imgWidth, imgHeight);
            const pdfBlob = doc.output("blob");
            const pdfUrl = URL.createObjectURL(pdfBlob);
            
            document.getElementById("pdfViewer").src = pdfUrl;
            
            // Hide the receipt content again
            receiptContent.style.position = 'absolute';
            receiptContent.style.left = '-9999px';
            receiptContent.style.top = '-9999px';
            receiptContent.style.visibility = 'hidden';
            
            document.getElementById('loading').style.display = 'none';
        });
    }

    window.onload = function() {
        if (document.fonts) {
            document.fonts.ready.then(function() {
                generatePDF();
            });
        } else {
            setTimeout(generatePDF, 500);
        }
    };
</script>

<script>
    function openPDF() {
    // Get the PDF URL from the iframe
    const pdfUrl = document.getElementById("pdfViewer").src;
    
    // Open in new tab
    if (pdfUrl) {
        window.open(pdfUrl, '_blank');
    } else {
        alert("PDF is still being generated. Please wait a moment and try again.");
    }
}
</script>
<script>
window.addEventListener("load", function() {
    let preloader = document.getElementById("preloader");

    setTimeout(() => {
        preloader.style.opacity = "0"; // Apply fade-out effect

        setTimeout(() => {
            preloader.style.display = "none";  // Hide after fade-out
            document.body.style.overflow = "auto"; // Allow scrolling after preloader disappears
        }, 500); // Matches CSS transition time

    }, 1500); // Delay for 1 second before fading out (adjust as needed)
});


</script>
<script>
        function openTab(event, tabName) {
            let i, tabContent, tabLinks;
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            tabLinks = document.getElementsByClassName("tab");
            for (i = 0; i < tabLinks.length; i++) {
                tabLinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            event.currentTarget.classList.add("active");
        }
    </script>
</body>


</html>

