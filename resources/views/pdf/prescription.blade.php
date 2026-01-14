<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ordonnance</title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        h1 {
            text-align: center;
        }

        .section {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

    </style>
</head>
<body>

    <h1>ORDONNANCE MÉDICALE</h1>

    <div class="section">
        <strong>Patient :</strong>
        {{ $prescription->consultation->patient->full_name }} <br>

        <strong>Date :</strong>
        {{ $prescription->consultation->consulted_at->format('d/m/Y') }} <br>

        <strong>Praticien :</strong>
        {{ $prescription->consultation->practitioner->name }}
    </div>

    <div class="section">
        <strong>Prescription :</strong><br>
        {{ $prescription->notes }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Médicament</th>
                <th>Posologie</th>
                <th>Durée</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prescription->items as $item)
            <tr>
                <td>{{ $item->medicine }}</td>
                <td>{{ $item->dosage }}</td>
                <td>{{ $item->duration }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <p><strong>Signature :</strong> _______________________</p>

</body>
</html>
