@extends('app')

@section('title', 'Afegir professional')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Afegir professional</h2>

    <form action="{{ route('professional_add') }}" method="post" class="space-y-4">
        @csrf

        <!-- Campos del formulario -->
        <input type="text" name="name" id="id_name" placeholder="Nom" class="input input-bordered w-full" required>
        <input type="text" name="surname1" id="id_surname1" placeholder="Primer cognom" class="input input-bordered w-full" required>
        <input type="text" name="surname2" id="id_surname2" placeholder="Segon cognom" class="input input-bordered w-full">
        <input type="text" name="dni" id="id_dni" placeholder="DNI" class="input input-bordered w-full" required>

        <select name="role" id="id_role" class="select select-bordered w-full">
            <option value="">Rol del professional</option>
            <option value="Directiu">Directiu</option>
            <option value="Administració">Administració</option>
            <option value="Tècnic">Tècnic</option>
        </select>

        <select name="employment_status" id="id_employment_status" class="select select-bordered w-full">
            <option value="">Estat de treball</option>
            <option value="Actiu">Actiu</option>
            <option value="Suplència">Suplència</option>
            <option value="Baixa">Baixa</option>
            <option value="No contractat">No contractat</option>
        </select>

        <input type="text" name="phone" id="id_phone" placeholder="Telèfon" class="input input-bordered w-full">
        <input type="email" name="email" id="id_email" placeholder="Correu electrònic" class="input input-bordered w-full">
        <input type="text" name="address" id="id_address" placeholder="Adreça" class="input input-bordered w-full">
        <input type="text" name="key_code" id="id_key_code" placeholder="Codi de clau" class="input input-bordered w-full">
        <textarea name="cvitae" id="id_cvitae" rows="4" placeholder="Currículum Vitae..." class="textarea textarea-bordered w-full"></textarea>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="shirt_size" id="id_shirt_size" class="select select-bordered w-full">
                <option value="">Talla samarreta</option>
                @foreach (['XS','S','M','L','XL','2XL','3XL','4XL','36','38','40','42','44','46','48','50','52','54','56'] as $size)
                    <option value="{{ $size }}">{{ $size }}</option>
                @endforeach
            </select>

            <select name="pants_size" id="id_pants_size" class="select select-bordered w-full">
                <option value="">Talla pantaló</option>
                @foreach (['XS','S','M','L','XL','2XL','3XL','4XL','36','38','40','42','44','46','48','50','52','54','56'] as $size)
                    <option value="{{ $size }}">{{ $size }}</option>
                @endforeach
            </select>

            <select name="shoe_size" id="id_shoe_size" class="select select-bordered w-full">
                <option value="">Talla sabata</option>
                @foreach (range(34, 56) as $size)
                    <option value="{{ $size }}">{{ $size }}</option>
                @endforeach
            </select>
        </div>

        <input type="text" name="login" id="id_login" placeholder="Usuari de login" class="input input-bordered w-full">
        <input type="password" name="password" id="id_password" placeholder="Contrasenya" class="input input-bordered w-full">

        <div>
            <p class="text-red text-center text-green-600">{{ session('success') }}</p>
        </div>

        <div class="flex gap-2 mt-4">
            <input type="submit" value="Acceptar" class="btn btn-primary flex-1">
            <input type="reset" value="Reset" class="btn flex-1">
        </div>
    </form>
</div>
@endsection
