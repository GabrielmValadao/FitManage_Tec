<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo!</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }

        p {
            margin-top: 15px;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <div class="container">
        <img src="{{ asset('images/logo trainsys.png') }}" alt="Logo Train Syst" style="width: 100%;">

        <h1>Bem-vindo, {{ $user->name }}!</h1>

        <p>Você se inscreveu no plano {{ $user->plan->description }}.</p>
        <p>Neste plano você pode cadastrar: {{ $user->plan->limit > 0 ? $user->plan->limit : 'um número ilimitado de' }}
            alunos.</p>

        <p>Aproveite todas as vantagens do nosso serviço!</p>
    </div>

</body>

</html>
