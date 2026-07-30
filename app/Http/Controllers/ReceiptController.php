<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Artisan;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use App\Support\Qr\QrPngGenerator;
use App\Support\UrlIdCoder;


class ReceiptController extends Controller
{   
    public function index() {
        $receiptCount = Receipt::count();
        $todayReceiptCount = Receipt::whereDate('created_at', Carbon::today())->count();
        $totalAmount = Receipt::sum('total_amount');
        $todayTotalAmount = Receipt::whereDate('created_at', Carbon::today())->sum('total_amount');
        $todayReceipts = Receipt::whereDate('created_at', Carbon::today())->get();

        return view('dashboard', compact('receiptCount', 'todayReceiptCount', 'totalAmount', 'todayTotalAmount', 'todayReceipts'));
    }
    public function showForm()
    {
        return view('receipt.form');
    }

    public function saveReceipt(Request $request)
    {
        $request->validate([
            'gate' => 'required|string',
            'trn' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'receipt_number' => 'required|string',
            'voucher_number' => 'nullable|string',
            'owner_name' => 'required|string',
            'vehicle_number' => 'required|string',
            'total_amount' => 'required|string',
            'research_support' => 'required|string',
            'collection_fee' => 'required|string',
            'vat' => 'required|string',
            'user_name' => 'required|string',
            'entity' => 'required|string',
            'refno' => 'required|string',
            'appno' => 'required|string',
        ]);

        // Save the receipt
        $receipt = Receipt::create($request->all());
        $receiptUrl = route('receipt.receipt-detail', ['id' => UrlIdCoder::encode($receipt->id)]); // Generate QR Code URL
        $data['qrimage'] = 'data:image/png;base64,' . base64_encode(
            QrPngGenerator::generate($receiptUrl, 135, 0, 'H', public_path('qr-logo.png'), 0.3)
        );

        return response()->json([
            'receipt' => view('receipt.partials.receipt', compact('receipt', 'data'))->render(),
        ]);

        // $receiptUrl = route('receipt.receipt-detail', ['id' => UrlIdCoder::encode($receipt->id)]);// Same page with query param
        // $qrCode = QrCode::size(135)->generate($receiptUrl);
        //  return response()->json([
        //     'receipt' => view('receipt.partials.receipt', compact('receipt', 'qrCode'))->render(),
        // ]);
    }
    public function showReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);
        $qrCode = QrCode::size(135)->generate(route('receipt.receipt-detail', ['id' => UrlIdCoder::encode($receipt->id)])); // Generate QR Code

        return view('receipt.show', compact('receipt', 'qrCode'));
    }

    public function receiptDetail($id)
    {
        $decryptedId = UrlIdCoder::decode($id);

        if ($decryptedId === null) {
            abort(404);
        }

        $receipt = Receipt::findOrFail($decryptedId);
        $qrCode = route('receipt.receipt-detail', ['id' => $id]); // Generate QR Code
        $data['qrimage'] = 'data:image/png;base64,' . base64_encode(
            QrPngGenerator::generate($qrCode, 135, 0, 'H', public_path('qr-logo.png'), 0.3)
        );

            return view('receipt.receipt-detail', compact('receipt', 'data','id'));
    }

    public function receiptPDF($id)
    {
        $receipt = Receipt::findOrFail($id);
        $qrCode = route('receipt.receipt-detail', ['id' => UrlIdCoder::encode($receipt->id)]); // Generate QR Code



        $data['qrimage'] = 'data:image/png;base64,' . base64_encode(
            QrPngGenerator::generate($qrCode, 135, 0, 'H', public_path('qr-logo.png'), 0.3)
        );

        return response()->json([
            'receipt' => view('receipt.receipt-detail', compact('receipt', 'data'))->render(),
        ]);
    }

    public function allReceipts()
    {
        $receipts = Receipt::orderBy('created_at', 'desc')->get();
        return view('receipt.all-receipts', compact('receipts'));
    }
    public function deleteReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();

        return response()->json(['success' => 'Receipt deleted successfully']);
    }
    public function editReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);
        return view('receipt.edit-receipt', compact('receipt'));
    }
    public function updateReceipt(Request $request, $id)
    { //dd($request->all());
        $request->validate([
        'gate' => 'required|string',
        'trn' => 'required|string',
        'date' => 'required|date',
        'time' => 'required',
        'receipt_number' => 'required|string',
        'owner_name' => 'required|string',
        'vehicle_number' => 'required|string',
        'total_amount' => 'required|string',
        'research_support' => 'required|string',
        'collection_fee' => 'required|string',
        'vat' => 'required|string',
        'user_name' => 'required|string',    
    ]);
       // dd($request->all()); 
        $receipt = Receipt::findOrFail($id);
        $receipt->update($request->all());

        return redirect()->route('all-receipts')->with('success', 'Receipt updated successfully!');
    }

    
        

}