<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Cirurgias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
    <h1>Relatório de Cirurgias</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Idade</th>
                <th>Cirurgião</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Status Social</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surgeries as $surgery)
                <tr>
                    <td>{{ $surgery->id }}</td>
                    <td>{{ $surgery->name }}</td>
                    <td>{{ $surgery->age }}</td>
                    <td>{{ $surgery->cirurgiao->name ?? 'Não informado' }}</td>
                    <td>{{ \Carbon\Carbon::parse($surgery->date)->format('d/m/Y') }}</td>
                    <td>{{ $surgery->time }}</td>
                    <td>{{ $surgery->social_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
