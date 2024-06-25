<?php

use App\Http\Controllers\InvoicePdfController;
use App\Http\Controllers\OfferingLetterPdfController;
use App\Http\Controllers\TravelDocumentPdfController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('pdf/offering-letter/{offeringLetter}', OfferingLetterPdfController::class)->name('pdf.offeringLetter');
Route::get('pdf/travel-document/{travelDocument}', TravelDocumentPdfController::class)->name('pdf.travelDocument');
Route::get('pdf/invoice/{invoice}', InvoicePdfController::class)->name('pdf.invoice');
