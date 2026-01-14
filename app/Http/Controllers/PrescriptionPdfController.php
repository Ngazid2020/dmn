<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionPdfController extends Controller
{
    public function download(Prescription $prescription)
    {
        $prescription->load([
            'consultation.medicalFile.patient',
            'consultation.practitioner',
            'items',
        ]);

        $pdf = Pdf::loadView(
            'pdf.prescription',
            compact('prescription')
        );

        return $pdf->download(
            'ordonnance-' . $prescription->id . '.pdf'
        );
    }
}
