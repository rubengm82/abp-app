<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('professional_add') }}" method="post">
        @csrf {{-- Esto es necesario para enviar, es un TOKEN!! --}}
        <input type="text" name="name" id="name" placeholder="Nombre" required><br>
        <input type="text" name="surname1" id="surname1" placeholder="Primer Apellido" required><br>
        <input type="text" name="surname2" id="surname2" placeholder="Segundo Apellido"><br>
        <select name="center_id" id="center_id">
            <option value="1">Centro 1</option>
            <option value="2">Centro 2</option>
            <option value="3">Centro 3</option>
        </select><br>
        <input type="text" name="role" id="role" placeholder="Rol del profesional"><br>
        <input type="text" name="phone" id="phone" placeholder="Teléfono"><br>
        <input type="email" name="email" id="email" placeholder="Email"><br>
        <input type="text" name="address" id="address" placeholder="Dirección"><br>
        <select name="employment_status" id="employment_status">
            <option value="Actiu">Activo</option>
            <option value="Suplència">Suplencia</option>
            <option value="Baixa">Baja</option>
            <option value="No contractat">No contratado</option>
        </select><br>
        <textarea name="cvitae" id="cvitae" rows="4" placeholder="Currículum Vitae"></textarea><br>
        <input type="text" name="login" id="login" placeholder="Usuario de login"><br>
        <input type="password" name="password" id="password" placeholder="Contraseña"><br>
        <input type="text" name="key_code" id="key_code" placeholder="Código de llave"><br>
        <input type="text" name="shirt_size" id="shirt_size" placeholder="Talla camiseta"><br>
        <input type="text" name="pants_size" id="pants_size" placeholder="Talla pantalón"><br>
        <input type="text" name="shoe_size" id="shoe_size" placeholder="Talla zapato"><br>
        <input type="submit" value="Aceptar">
        <input type="reset" value="Reset">
    </form>
</body>
</html>
