<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo!</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">

    <table width="100%" background-color="#dbd5b5" style="padding: 20px;">
        <tr>
            <td>
                <img src="https://example.com/seu-logo.png" alt="Seu Logo" style="max-width: 200px;">
            </td>
        </tr>
    </table>

    <!-- Corpo do E-mail -->
    <table width="100%" style="padding: 20px;">
        <tr>
            <td>
                <h1 style="color: #333;">Bem-vindo, {{ $user->name }}!</h1>

                <p>Você se inscreveu no plano {{ $user->plan->description }}.</p>
                <p>Este plano suporta até {{ $user->plan->limit }} alunos.</p>

                <p>Aproveite todas as vantagens do nosso serviço!</p>
            </td>
        </tr>
    </table>
</body>

</html>
