document.addEventListener('DOMContentLoaded', () => {

    // Open modals
    document.querySelectorAll('[data-open-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.openModal);
            if (modal) {
                modal.showModal();
            }
        });
    });

    // Close modals
    document.querySelectorAll('[data-close-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.closeModal);
            if (modal) {
                modal.close();
            }
        });
    });

    // Prevent double submit and change button text
    document.querySelectorAll('dialog form').forEach(form => {
        form.addEventListener('submit', e => {
            const btn = form.querySelector('[type="submit"]');

            // Only proceed if button exists and is not disabled
            const canSubmit = btn && !btn.disabled;
            if (!canSubmit) {
                e.preventDefault();
            } else {
                btn.textContent = btn.dataset.loadingText || 'Processing...';
                setTimeout(() => btn.disabled = true, 1); // Allow form to submit
            }
        });
    });

    // Open edit modal with data
    document.querySelectorAll('[data-edit-url]').forEach(btn => {
        btn.addEventListener('click', () => {
            const url = btn.dataset.editUrl;
            let note = btn.dataset.editNote;
            let restricted = btn.dataset.editRestricted;

            try { 
                note = JSON.parse(note);
                // JSON.parse is needed for restricted because @json() in Blade outputs a JSON-encoded string
                if (restricted !== undefined && restricted !== null) {
                    restricted = JSON.parse(restricted);
                }
            } catch(e) {
                console.error('Error parsing the note:', e, 'Received value:', note);
            }

            const editForm = document.getElementById('editNoteForm');
            const editText = document.getElementById('editNoteText');
            const editRestricted = document.getElementById('editNoteRestricted');
            const modal = document.getElementById('editNoteModal');

            const canOpen = editForm && editText && modal;
            if (canOpen) {
                editText.value = note;
                // Only set checkbox if it exists (user is Directiu) and restricted value is available
                if (editRestricted && restricted !== undefined && restricted !== null) {
                    // Handle both boolean and integer values (true/1 = checked, false/0 = unchecked)
                    editRestricted.checked = restricted === true || restricted === 1 || restricted === '1';
                }
                editForm.action = url;
                modal.showModal();
            }
        });
    });

});
