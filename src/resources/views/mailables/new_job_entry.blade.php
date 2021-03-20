<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Candidato</title>
</head>
<body>
    <h1>Novo Candidato</h1>

    {{ $mail_data['name'] }}
    <br>
    {{ $mail_data['email'] }}
    <br>
    {{ $mail_data['additional_info'] }}
    <br>
    <a href="{{ $mail_data['resume_url'] }}">Baixar curriculo</a>
    <br>
    
</body>
</html>