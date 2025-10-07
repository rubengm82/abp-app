<!DOCTYPE html>
<html lang="ca" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Afegir professional</title>
    @vite('resources/css/app.css')
</head>
<body>
    <form action="{{ route('professional_add') }}" method="post" class="p-6 space-y-4 bg-base-100 rounded-lg shadow-md">
    @csrf

    <!-- Informació professional -->
    <input type="text" name="name" id="id_name" placeholder="Nom" class="input input-bordered" required><br>
    <input type="text" name="surname1" id="id_surname1" placeholder="Primer cognom" class="input input-bordered" required><br>
    <input type="text" name="surname2" id="id_surname2" placeholder="Segon cognom" class="input input-bordered"><br>
    <input type="text" name="dni" id="id_dni" placeholder="DNI" class="input input-bordered" required><br>
    
    <select name="role" id="id_role" class="select select-bordered">
        <option value="">Rol del professional</option>
        <option value="Directiu">Directiu</option>
        <option value="Administració">Administració</option>
        <option value="Tècnic">Tècnic</option>
    </select><br>

    <!-- Estat laboral -->
    <select name="employment_status" id="id_employment_status" class="select select-bordered">
        <option value="">Estat de treball</option>
        <option value="Actiu">Actiu</option>
        <option value="Suplència">Suplència</option>
        <option value="Baixa">Baixa</option>
        <option value="No contractat">No contractat</option>
    </select><br><br>
    
    <!-- Informació de contacte -->
    <input type="text" name="phone" id="id_phone" placeholder="Telèfon" class="input input-bordered"><br>
    <input type="email" name="email" id="id_email" placeholder="Correu electrònic" class="input input-bordered"><br>
    <input type="text" name="address" id="id_address" placeholder="Adreça" class="input input-bordered"><br>
    <input type="text" name="key_code" id="id_key_code" placeholder="Codi de clau" class="input input-bordered"><br>
    <textarea name="cvitae" id="id_cvitae" rows="4" placeholder="Currículum Vitae, pots escriure aquí..." class="textarea textarea-bordered"></textarea><br>
    <br>

    <!-- Talles -->
    <select name="shirt_size" id="id_shirt_size" class="select select-bordered">
        <option value="">Talla samarreta</option>
        <option value="XS">XS</option>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
        <option value="3XL">3XL</option>
        <option value="4XL">4XL</option>
        <option value="5XL">5XL</option>
    </select><br>

    <select name="pants_size" id="id_pants_size" class="select select-bordered">
        <option value="">Talla pantaló</option>
        <option value="XS">XS</option>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
        <option value="3XL">3XL</option>
        <option value="4XL">4XL</option>
        <option value="5XL">5XL</option>
    </select><br>

    <select name="shoe_size" id="id_shoe_size" class="select select-bordered">
        <option value="">Talla sabata</option>
        <option value="34">34</option>
        <option value="35">35</option>
        <option value="36">36</option>
        <option value="37">37</option>
        <option value="38">38</option>
        <option value="39">39</option>
        <option value="40">40</option>
        <option value="41">41</option>
        <option value="42">42</option>
        <option value="43">43</option>
        <option value="44">44</option>
        <option value="45">45</option>
        <option value="46">46</option>
        <option value="47">47</option>
        <option value="48">48</option>
        <option value="49">49</option>
        <option value="50">50</option>
    </select><br><br>

    <!-- Informació addicional -->
    <input type="text" name="login" id="id_login" placeholder="Usuari de login" class="input input-bordered"><br>
    <input type="password" name="password" id="id_password" placeholder="Contrasenya" class="input input-bordered"><br>
    <br>

    <input type="submit" id="id_submit" value="Acceptar" class="btn btn-primary">
    <input type="reset" id="id_reset" value="Reset" class="btn btn-primary">
</form>

</body>
</html>
