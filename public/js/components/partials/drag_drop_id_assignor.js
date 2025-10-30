// Handle form input igual
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('assignmentFormManual');
    form.addEventListener('submit', function(e) {
        const assigned = document.getElementById('assigned-manual');
        const professionalItems = assigned.querySelectorAll('.professional-item-manual');
        form.querySelectorAll('input[name="professional_ids[]"]').forEach(input => input.remove());
        professionalItems.forEach(function(item) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'professional_ids[]';
            input.value = item.dataset.id;
            form.appendChild(input);
        });
    });
});
// Drop function
function handleDrop(e, targetList) {
    e.preventDefault();
    var data = e.dataTransfer.getData("professional-id");
    var draggedItem = document.getElementById(data);
    // Si el item arrastrado no es el mismo que el targetList y no es el mismo que el elemento sobre el que se deja caer, se añade al targetList
    if (draggedItem && draggedItem !== targetList && draggedItem !== e.target) {
        targetList.appendChild(draggedItem);
    }
}