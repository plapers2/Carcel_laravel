<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Visitas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: center;
        }

        td {
            padding: 6px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .terminada {
            background-color: #c6efce;
        }

        .en-curso {
            background-color: #fff3cd;
        }

        .desaprobada {
            background-color: #f8d7da;
        }
    </style>
</head>

<body>

<h1>Reporte de Visitas</h1>

<div class="info">
    <strong>Fecha generación:</strong> {{ now()->format('d/m/Y H:i') }}
</div>

<table>
    <thead>
        <tr>
            <th>Prisoner</th>
            <th>Visitor</th>
            <th>RelationShip</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>State</th>
        </tr>
    </thead>

    <tbody>
        @foreach($datos as $visita)
            @php
                $clase = match($visita->verification) {
                    'Finished' => 'finished',
                    'In progress' => 'in-progress',
                    'Rejected' => 'rejected',
                    default => ''
                };
            @endphp

            <tr class="{{ $clase }}">
                <td>{{ $visita->prisoner->name }}</td>
                <td>{{ $visita->visitor->name }}</td>
                <td>{{ $visita->visitor_relationship }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($visita->start_date)->format('d/m/Y H:i') }}
                </td>

                <td>
                    {{ $visita->end_date
                        ? \Carbon\Carbon::parse($visita->end_date)->format('d/m/Y H:i')
                        : 'In progress' }}
                </td>

                <td>{{ $visita->verification }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
