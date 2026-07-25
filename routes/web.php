<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ReceiptController;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;


Route::middleware(['auth'])->group(function () {
    Route::get('/', [ReceiptController::class, 'index'])->name('dashboard');

Route::get('/receipt/form', [ReceiptController::class, 'showForm'])->name('receipt.form');
Route::post('/receipt/save', [ReceiptController::class, 'saveReceipt'])->name('receipt.save');

// Static routes should be defined before dynamic routes


Route::get('receipt/receipt-detail', function () {
    return view('receipt/receipt-detail');
})->name('receipt-detail');

Route::get('receipt/all-receipts', [ReceiptController::class, 'allReceipts'])->name('all-receipts');

// Dynamic route should be at the end to avoid conflicts
Route::get('/receipt/{id}', [ReceiptController::class, 'showReceipt'])->name('receipt.show');
//Route::get('/scan/{id}', [ReceiptController::class, 'receiptDetail'])->name('receipt.receipt-detail');

Route::delete('/receipt/{id}', [ReceiptController::class, 'deleteReceipt'])->name('receipt.delete');

Route::get('/receipt/{id}/edit', [ReceiptController::class, 'editReceipt'])->name('receipt.edit');
Route::put('/receipt/{id}', [ReceiptController::class, 'updateReceipt'])->name('receipt.update');
});

require __DIR__.'/auth.php';
Route::get('/file/{id}', [ReceiptController::class, 'receiptPDF'])->name('receipt.pdf-receipt');
Route::get('/scan/{id}', [ReceiptController::class, 'receiptDetail'])->name('receipt.receipt-detail');
Route::get('/receipt/{id}/pdf', 'ReceiptController@generatePDF')->name('receipt.pdf');
// Route::get('/partials/pdf-receipt/{id}', [ReceiptController::class, 'receiptDetail']);

//Route::get('/receipt/{id}/pdf', 'ReceiptController@viewInvoicePdf')->name('invoice.pdf.view');

Route::get('/receipt/{id}/pdf', [ReceiptController::class,'viewInvoicePdf'])->name('invoice.pdf.view');
Route::get('/receipt/{id}', [ReceiptController::class,'showInvoicePage'])->name('invoice.show');

