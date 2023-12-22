<!DOCTYPE html>
<html>

<head>
    <title>Detalhes do Treino do Estudante - {{ name }}</title>
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
            @foreach ($student->workouts as $workout)
                <tr>
                    <td>{{ day }}</td>
                    <td>{{ exercise }}</td>
                    <td>{{ repetitions }}</td>
                    <td>{{ weight }}</td>
                    <td>{{ break_time }}</td>
                    <td>{{ observation }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
