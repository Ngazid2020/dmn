<!-- resources/views/pdf/medical-file.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dossier Médical</title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        h2 {
            border-bottom: 1px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td,
        th {
            border: 1px solid #ccc;
            padding: 5px;
        }

    </style>
</head>
<body>

    <h1>Dossier Médical – {{ $medicalFile->reference }}</h1>

    <h2>Patient</h2>
    <p>
        <strong>Nom :</strong> {{ $medicalFile->patient->full_name }}<br>
        <strong>Date de naissance :</strong> {{ $medicalFile->patient->date_of_birth }}
    </p>

    @foreach ($medicalFile->consultations as $consultation)
    <h2>Consultation – {{ $consultation->consulted_at }}</h2>

    <p><strong>Motif :</strong> {{ $consultation->complaint }}</p>
    <p><strong>Diagnostic :</strong> {{ $consultation->diagnosis }}</p>

    @if ($consultation->prescriptions->count())
    <h3>Prescriptions</h3>
    <ul>
        @foreach ($consultation->prescriptions as $prescription)
        @foreach ($prescription->items as $item)
        <li>
            {{ $item->medicine }} –
            {{ $item->dosage }} –
            {{ $item->duration }}
        </li>
        @endforeach
        @endforeach
    </ul>
    @endif

    @if ($consultation->exams->count())
    <h3>Examens</h3>
    @foreach ($consultation->exams as $exam)
    <p>
        <strong>{{ $exam->name }}</strong>
        ({{ $exam->status }})
    </p>
    @endforeach
    @endif
    @endforeach

</body>
</html>
