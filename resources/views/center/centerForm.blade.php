<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route("center_add") }}" method="post">
        @csrf {{-- Esto es necesario para enviar, es un TOKEN!! --}}
        <input type="text" name="name" id="id_name" placeholder="Nom"><br>
        <input type="text" name="address" id="id_adress" placeholder="Adreça"><br>
        <input type="text" name="phone" id="id_phone" placeholder="Telèfon"><br>
        <input type="text" name="email" id="id_email" placeholder="Email"><br>
        <input type="submit" value="Aceptar">
        <input type="reset" value="Reset">
    </form>
</body>
</html>