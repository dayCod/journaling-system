<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as BarryvdhPDF;

class InvoicePdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Invoice $invoice)
    {
        $pdf = BarryvdhPDF::loadView('pdf.invoice', ['invoice' => $invoice]);

        return $pdf->stream($invoice->code.'.pdf');
    }
}
