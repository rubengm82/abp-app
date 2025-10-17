@props([
    'id',          // Unique ID for the modal
    'msj' => 'Estàs segur?',  // Message inside the modal
    'btnText' => 'Obrir'      // Text for the button that opens the modal
])

<!-- Hidden checkbox that controls the modal -->
<input type="checkbox" id="{{ $id }}" class="hidden peer" />

<!-- Button that opens the modal -->
<label for="{{ $id }}" class="btn btn-xs btn-error cursor-pointer">
    {{ $btnText }}
</label>

<!-- Modal -->
<div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50
            opacity-0 pointer-events-none transition-opacity duration-200
            peer-checked:opacity-100 peer-checked:pointer-events-auto">
    <div class="bg-white rounded-lg p-6 w-80">
        <p class="mb-6 text-gray-600">{{ $msj }}</p>
        <div class="flex justify-end space-x-2">
            <!-- Cancel: closes the modal -->
            <label for="{{ $id }}" class="btn btn-sm cursor-pointer">Cancel·lar</label>

            <!-- Accept / Action: slot where you put form or link -->
            {{ $slot }}
        </div>
    </div>
</div>
