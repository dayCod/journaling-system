<?php

namespace App\Http\Controllers;

use App\Models\OfferingLetter;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as BarryvdhPDF;

class OfferingLetterPdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(OfferingLetter $offeringLetter)
    {
        $pdf = BarryvdhPDF::loadView('pdf.offering-letter', ['offeringLetter' => $offeringLetter]);

        return $pdf->stream($offeringLetter->code.'.pdf');
    }
}
