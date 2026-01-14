<?php

namespace App\Http\Controllers;

use App\Models\MedicalFile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MedicalFilePdfController extends Controller
{
    public function show(MedicalFile $medicalFile)
    {
        $medicalFile->load([
            'patient',
            'consultations.prescriptions.items',
            'consultations.exams.results',
        ]);

        $pdf = Pdf::loadView(
            'pdf.medical-file',
            compact('medicalFile')
        );

        return $pdf->stream(
            'dossier-medical-' . $medicalFile->reference . '.pdf'
        );
    }
}
