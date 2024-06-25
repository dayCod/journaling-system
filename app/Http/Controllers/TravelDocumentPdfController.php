<?php

namespace App\Http\Controllers;

use App\Models\TravelDocument;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as BarryvdhPDF;

class TravelDocumentPdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(TravelDocument $travelDocument)
    {
        $pdf = BarryvdhPDF::loadView('pdf.travel-document', ['travelDocument' => $travelDocument]);

        return $pdf->stream($travelDocument->code.'.pdf');
    }
}
