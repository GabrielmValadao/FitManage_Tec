<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo!</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">

    <table width="100%" style="padding: 20px;">
        <tr>
            <td>
                <img src="{{ asset('images/logo trainsys.png') }}" alt="Logo Train Syst" style="width: 100%;">
            </td>
        </tr>
    </table>


    <table width="100%" style="padding: 20px;" text-aling="center">
        <tr>
            <td>
                <h1 style="color: #333;">Bem-vindo, {{ $user->name }}!</h1>

                <p>Você se inscreveu no plano {{ $user->plan->description }}.</p>
                <p>Neste plano você pode cadastrar: {{ $user->plan->limit > 0 ? $user->plan->limit: 'ilimitado número de'}} alunos.</p>

                <p>Aproveite todas as vantagens do nosso serviço!</p>
            </td>
        </tr>
    </table>
</body>

</html>
