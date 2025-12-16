document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('id_type');
    const leaveSection = document.getElementById('leaveInfoSection');
    
    function toggleLeaveSection() {
        const type = typeSelect.value;
        const startDateInput = document.getElementById('id_start_date');
        const endDateInput = document.getElementById('id_end_date');
        const durationInput = document.getElementById('id_duration');
        
        if (type === 'Amb baixa') {
            leaveSection.style.display = 'block';
        } else {
            leaveSection.style.display = 'none';
            // Clear input values when "Sin baixa" is selected
            if (startDateInput) startDateInput.value = '';
            if (endDateInput) endDateInput.value = '';
            if (durationInput) durationInput.value = '';
        }
    }
    
    // Initialize on page load based on current select value
    toggleLeaveSection();
    
    // Handle changes
    typeSelect.addEventListener('change', toggleLeaveSection);
});