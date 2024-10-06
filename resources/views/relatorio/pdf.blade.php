<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Cirurgias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Diminuir o tamanho da fonte para caber mais dados */
        }
        h1 {
            text-align: center;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 2px; /* Reduzir o padding para caber mais informações */
            text-align: left;
            word-wrap: break-word; /* Quebra de linha automática para o conteúdo */
        }
        th {
            background-color: #f0f0f0; /* Cor de fundo para cabeçalho */
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Relatório de Cirurgias</h1>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Nome do Paciente</th>
                <th>Idade</th>
                <th>Estado</th>
                <th>Cidade</th>
                <th>Prontuário</th>
                <th>Origem do Setor</th>
                <th>Indicação</th>
                <th>Anestesia</th>
                <th>Anestesista</th>
                <th>Cirurgia</th>
                <th>Cirurgião</th>
                <th>Pediatra</th>
                <th>Enfermeiro</th>
                <th>Data de Admissão</th>
                <th>Hora de Admissão</th>
                <th>Hora de Término</th>
                <th>Apgar</th>
                <th>Ligadura</th>
                <th>Status Social</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surgeries as $surgery)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($surgery->date)->format('d/m/Y') }}</td>
                    <td>{{ $surgery->time }}</td>
                    <td>{{ $surgery->name }}</td>
                    <td>{{ $surgery->age }}</td>
                    <td>{{ $surgery->state->name ?? 'N/A' }}</td>
                    <td>{{ $surgery->city->name ?? 'N/A' }}</td>
                    <td>{{ $surgery->medical_record }}</td>
                    <td>{{ $surgery->origin_department }}</td>
                    <td>{{ $surgery->indication->descricao ?? 'N/A' }}</td>
                    <td>{{ $surgery->anesthesia }}</td>
                    <td>{{ $surgery->anestesista->name ?? 'N/A' }}</td>
                    <td>{{ $surgery->surgery_type->descricao ?? 'N/A' }}</td>
                    <td>{{ $surgery->cirurgiao->name ?? 'N/A' }}</td>
                    <td>{{ $surgery->pediatra->name ?? 'N/A' }}</td>
                    <td>{{ $surgery->enfermeiro->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($surgery->admission_date)->format('d/m/Y') }}</td>
                    <td>{{ $surgery->admission_time }}</td>
                    <td>{{ $surgery->end_time }}</td>
                    <td>{{ $surgery->apgar ?? 'N/A' }}</td>
                    <td>{{ $surgery->ligation ? 'Sim' : 'Não' }}</td>
                    <td>{{ $surgery->social_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
