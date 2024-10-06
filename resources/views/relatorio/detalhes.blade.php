<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Cirurgia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Detalhes da Cirurgia</h1>

    <table>
        <tr>
            <th>ID</th>
            <td>{{ $surgery->id }}</td>
        </tr>
        <tr>
            <th>Paciente</th>
            <td>{{ $surgery->name }}</td>
        </tr>
        <tr>
            <th>Idade</th>
            <td>{{ $surgery->age }}</td>
        </tr>
        <tr>
            <th>Prontuário Médico</th>
            <td>{{ $surgery->medical_record }}</td>
        </tr>
        <tr>
            <th>Data de Admissão</th>
            <td>{{ \Carbon\Carbon::parse($surgery->admission_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Hora de Admissão</th>
            <td>{{ $surgery->admission_time }}</td>
        </tr>
        <tr>
            <th>Departamento de Origem</th>
            <td>{{ $surgery->origin_department }}</td>
        </tr>
        <tr>
            <th>Data da Cirurgia</th>
            <td>{{ \Carbon\Carbon::parse($surgery->date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Hora da Cirurgia</th>
            <td>{{ $surgery->time }}</td>
        </tr>
        <tr>
            <th>Cirurgião</th>
            <td>{{ $surgery->cirurgiao->name ?? 'Não informado' }}</td>
        </tr>
        <tr>
            <th>Anestesista</th>
            <td>{{ $surgery->anestesista->name ?? 'Não informado' }}</td>
        </tr>
        <tr>
            <th>Pediatra</th>
            <td>{{ $surgery->pediatra->name ?? 'Não informado' }}</td>
        </tr>
        <tr>
            <th>Enfermeiro</th>
            <td>{{ $surgery->enfermeiro->name ?? 'Não informado' }}</td>
        </tr>
        <tr>
            <th>Anestesia</th>
            <td>{{ $surgery->anesthesia }}</td>
        </tr>
        <tr>
            <th>APGAR</th>
            <td>{{ $surgery->apgar ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Hora de Término</th>
            <td>{{ $surgery->end_time }}</td>
        </tr>
        <tr>
            <th>Ligadura</th>
            <td>{{ $surgery->ligation ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <th>Status Social</th>
            <td>{{ $surgery->social_status }}</td>
        </tr>
    </table>
</body>
</html>
