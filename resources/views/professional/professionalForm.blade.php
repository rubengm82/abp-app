<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario de Profesional</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
        .required {
            color: red;
        }
        .button-group {
            text-align: center;
            margin-top: 30px;
        }
        input[type="submit"], input[type="reset"] {
            width: auto;
            padding: 12px 30px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        input[type="reset"] {
            background-color: #f44336;
            color: white;
        }
        input[type="reset"]:hover {
            background-color: #da190b;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Formulario de Profesional</h1>
        
        <form action="{{ route('professional_add') }}" method="post">
            @csrf {{-- Esto es necesario para enviar, es un TOKEN!! --}}
            
            <!-- Información básica -->
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nombre <span class="required">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <label for="surname1">Primer Apellido <span class="required">*</span></label>
                    <input type="text" name="surname1" id="surname1" placeholder="Primer Apellido" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="surname2">Segundo Apellido</label>
                <input type="text" name="surname2" id="surname2" placeholder="Segundo Apellido">
            </div>

            <!-- Centro y rol -->
            <div class="form-row">
                <div class="form-group">
                    <label for="center_id">Centro</label>
                    <select name="center_id" id="center_id" placeholder="Seleccionar Centro">
                        
                        <option value="1">Centro 1</option>
                        <option value="2">Centro 2</option>
                        <option value="3">Centro 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="role">Rol</label>
                    <input type="text" name="role" id="role" placeholder="Rol del profesional">
                </div>
            </div>

            <!-- Información de contacto -->
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" name="phone" id="phone" placeholder="Teléfono">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email">
                </div>
            </div>

            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" id="address" placeholder="Dirección">
            </div>

            <!-- Estado laboral -->
            <div class="form-group">
                <label for="employment_status">Estado Laboral</label>
                <select name="employment_status" id="employment_status">
                    <option value="Actiu">Activo</option>
                    <option value="Suplència">Suplencia</option>
                    <option value="Baixa">Baja</option>
                    <option value="No contractat">No contratado</option>
                </select>
            </div>

            <!-- Información adicional -->
            <div class="form-group">
                <label for="cvitae">Currículum Vitae</label>
                <textarea name="cvitae" id="cvitae" rows="4" placeholder="Currículum Vitae"></textarea>
            </div>

            <!-- Credenciales de acceso -->
            <div class="form-row">
                <div class="form-group">
                    <label for="login">Usuario Login</label>
                    <input type="text" name="login" id="login" placeholder="Usuario de login">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Contraseña">
                </div>
            </div>

            <!-- Código de llave -->
            <div class="form-group">
                <label for="key_code">Código de Llave</label>
                <input type="text" name="key_code" id="key_code" placeholder="Código de llave">
            </div>

            <!-- Tallas -->
            <div class="form-row">
                <div class="form-group">
                    <label for="shirt_size">Talla Camiseta</label>
                    <input type="text" name="shirt_size" id="shirt_size" placeholder="Talla camiseta">
                </div>
                <div class="form-group">
                    <label for="pants_size">Talla Pantalón</label>
                    <input type="text" name="pants_size" id="pants_size" placeholder="Talla pantalón">
                </div>
                <div class="form-group">
                    <label for="shoe_size">Talla Zapato</label>
                    <input type="text" name="shoe_size" id="shoe_size" placeholder="Talla zapato">
                </div>
            </div>

            <div class="button-group">
                <input type="submit" value="Crear Profesional">
                <input type="reset" value="Limpiar Formulario">
            </div>
        </form>
    </div>
</body>
</html>
