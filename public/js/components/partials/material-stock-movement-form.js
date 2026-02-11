document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('form_movement');
    if (!form) return;

    var confirmedInput = document.getElementById('confirmed_negative');
    form.addEventListener('submit', function(e) {
        var needsConfirm = confirmedInput.value !== '1'
            && document.getElementById('id_type').value === 'Sortida';
        if (needsConfirm) {
            var sel = document.getElementById('id_material_stock_item_id');
            var opt = sel.options[sel.selectedIndex];
            var currentStock = parseInt(opt.getAttribute('data-quantity') || 0, 10);
            var qty = parseInt(document.getElementById('id_quantity').value || 0, 10);
            if (qty > currentStock) {
                e.preventDefault();
                document.getElementById('modal_negative_quantity').checked = true;
            }
        }
    });
    document.getElementById('btn_confirm_negative').addEventListener('click', function() {
        confirmedInput.value = '1';
        document.getElementById('modal_negative_quantity').checked = false;
        form.submit();
    });
});
