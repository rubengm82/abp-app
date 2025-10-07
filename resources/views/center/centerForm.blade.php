<!DOCTYPE html>
<html lang="ca" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Afegir centre</title>
    @vite('resources/css/app.css')
</head>
<body>
    <form action="{{ route("center_add") }}" method="post">
        @csrf {{-- Token necessari per enviar el formulari --}}

        <input type="text" name="name" id="id_name" placeholder="Nom" class="input input-bordered" required><br>
        <input type="text" name="address" id="id_adress" placeholder="Adreça" class="input input-bordered"><br>
        <input type="text" name="phone" id="id_phone" placeholder="Telèfon" class="input input-bordered"><br>
        <input type="text" name="email" id="id_email" placeholder="Email" class="input input-bordered"><br>
        <input type="submit" value="Acceptar" class="btn btn-primary">
        <input type="reset" value="Reset" class="btn btn-primary">
    </form>
</body>
</html>