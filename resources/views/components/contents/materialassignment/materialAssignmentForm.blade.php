@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Afegir Assignació de Material</h1>
    
    <form action="{{ route('materialassignment_store') }}" method="POST" class="space-y-4">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Professional:</span>
                </label>
                <select name="professional_id" class="select select-bordered w-full" required>
                    <option value="">Selecciona un professional</option>
                    @foreach($professionals as $professional)
                        <option value="{{ $professional->id }}">
                            {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Data d'assignació:</span>
                </label>
                <input type="date" name="assignment_date" class="input input-bordered w-full" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Talla samarreta:</span>
                </label>
                <select name="shirt_size" class="select select-bordered w-full">
                    <option value="">Selecciona talla</option>
                    @foreach(['XS','S','M','L','XL','2XL','3XL','4XL','36','38','40','42','44','46','48','50','52','54','56'] as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Talla pantaló:</span>
                </label>
                <select name="pants_size" class="select select-bordered w-full">
                    <option value="">Selecciona talla</option>
                    @foreach(['XS','S','M','L','XL','2XL','3XL','4XL','36','38','40','42','44','46','48','50','52','54','56'] as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Talla sabata:</span>
                </label>
                <select name="shoe_size" class="select select-bordered w-full">
                    <option value="">Selecciona talla</option>
                    @foreach(range(34, 56) as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-control">
            <label class="label">
                <span class="label-text">Assignat per:</span>
            </label>
            <select name="assigned_by_professional_id" class="select select-bordered w-full">
                <option value="">Selecciona qui assigna</option>
                <!-- TODO: Temporal, usar el usuario logueado -->
                @foreach($professionals as $professional)
                    <option value="{{ $professional->id }}">
                        {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-control">
            <label class="label">
                <span class="label-text">Observacions:</span>
            </label>
            <textarea name="observations" class="textarea textarea-bordered w-full" rows="3" placeholder="Observacions sobre l'assignació..."></textarea>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('materialassignments_list') }}" class="btn btn-outline">Cancel·lar</a>
            <button type="submit" class="btn btn-primary">Crear Assignació</button>
        </div>

        <div>
            <p class="text-center text-green-600">{{ session('success') }}</p>
        </div>
    </form>
</div>

@include('components.layout.mainToasts')
@endsection
