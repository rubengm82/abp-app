@props([
    'id',                // Unique ID for the modal
    'msj' => 'Estàs segur?',  // Message text
    'btnText' => 'Obrir',     // Button text
    'textSize' => 'text-sm',  // Tailwind text size for the message
    'width' => 'w-100',       // Tailwind width class for the modal
])

<!-- Hidden checkbox that controls the modal -->
<input type="checkbox" id="{{ $id }}" class="hidden peer" />

<!-- Button that opens the modal -->
<label for="{{ $id }}" {{ $attributes->merge(['class' => 'btn cursor-pointer']) }}>
    {{ $btnText }}
</label>

<!-- Modal -->
<div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50
            opacity-0 pointer-events-none transition-opacity duration-200
            peer-checked:opacity-100 peer-checked:pointer-events-auto">
    <div class="bg-base-100 text-base-content rounded-lg p-6 {{ $width }}">
        <p class="mb-6 {{ $textSize }}">{{ $msj }}</p>
        <div class="flex justify-end space-x-2">
            <!-- Cancel -->
            <label for="{{ $id }}" class="btn btn-sm cursor-pointer">Cancel·lar</label>

            <!-- Accept / Action -->
            <div class="accept-btn-container">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>