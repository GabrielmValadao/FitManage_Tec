<!DOCTYPE html>
<html>

<head>
    <title>Detalhes do Treino do Estudante - {{ $workoutsDay[0]['name'] }}</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: lightgray;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>Dia</th>
                <th>Exercício</th>
                <th>Repetições</th>
                <th>Peso</th>
                <th>Tempo de Intervalo</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workoutsDay as $workout)
                <tr>
                    <td>{{ $workout['day'] }}</td>
                    <td>{{ $workout['exercise'] }}</td>
                    <td>{{ $workout['repetitions'] }}</td>
                    <td>{{ $workout['weight'] }}</td>
                    <td>{{ $workout['break_time'] }}</td>
                    <td>{{ $workout['observation'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
