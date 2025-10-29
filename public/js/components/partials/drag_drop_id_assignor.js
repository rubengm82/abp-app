document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('assignmentForm');
    
    form.addEventListener('submit', function(e) {
        const assigned = document.getElementById('assigned');
        const professionalItems = assigned.querySelectorAll('.professional-item');
        
        // Clean old hidden inputs inside the form
        form.querySelectorAll('input[name="professional_ids[]"]').forEach(input => input.remove());
        
        // Create new hidden inputs with the IDs of the assigned list
        professionalItems.forEach(function(item) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'professional_ids[]';
            input.value = item.dataset.id;
            form.appendChild(input);
        });
    });
});
