document.addEventListener('DOMContentLoaded', () => {

    // Button clear
    let btn_clear_signature = document.getElementById('btn_clear_signature');
    let btn_save_signature = document.getElementById('btn_save_signature');

    // Canvas
    let canvas = document.getElementById('signature_professional_canvas');
    let context = canvas.getContext('2d');
    
    // Border and background
    context.strokeStyle = "#555";
    context.lineWidth = 2;
    context.strokeRect(1, 1, 199, 199);

    context.fillStyle = "#EEE";
    context.fillRect(2, 2, 196, 196);

    // ////////
    // VARS //
    // ///////
    let drawing = false;
    let lastX = 0;
    let lastY = 0;

    // ////////////
    // Functions //
    // ////////////
    function mouse_down(e){
        drawing = true;
        context.strokeStyle = "#005BAC";
        lastX = e.offsetX;
        lastY = e.offsetY;
    }
    
    function mouse_up(){
        drawing = false;
        btn_save_signature.disabled = false;
    }
    
    function mouse_move(e){
        if(drawing){
            context.beginPath();
            context.moveTo(lastX, lastY);
            context.lineTo(e.offsetX, e.offsetY);
            context.stroke();

            lastX = e.offsetX;
            lastY = e.offsetY;
        }
    }

    function remove_and_clear_signature() {
        context.clearRect(2, 2, 196, 196);
        context.fillStyle = "#EEE";
        context.fillRect(2, 2, 196, 196);
        btn_save_signature.disabled = true;
        // clear_signaure();
    }

    // Update signature on DB (Clear o update)
    // function clear_signaure() {
    //     const id = btn_clear_signature.dataset.id;

    //     fetch(`/materialassignment/clear-signature/${id}`, {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //             'Accept': 'application/json',
    //         },
    //         credentials: 'same-origin'
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if(data.success) {
    //             // console.log('Firma eliminada en la BBDD');
    //             toast_signature(data.message);
    //             btn_save_signature.disabled = true;
    //         }
    //     })
    //     .catch(error => console.error('Error al limpiar firma:', error));
    // }

    function save_signaure() {
        const id = btn_save_signature.dataset.id;

        // Convertimos canvas a base64
        const canvasData = canvas.toDataURL('image/png');

        fetch(`/materialassignment/save-signature/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ signature: canvasData })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toast_signature(data.message);
            }
        })
        .catch(error => console.error('Error al guardar firma:', error));
    }

    function toast_signature(message) {
        const toastContainer = document.createElement('div');
        toastContainer.classList.add('toast', 'toast-end');

        const alertDiv = document.createElement('div');
        alertDiv.classList.add('alert', 'alert-success');
        alertDiv.innerHTML = `<span>${message}</span>`;

        toastContainer.appendChild(alertDiv);
        document.body.appendChild(toastContainer);

        // Auto-borrar el toast tras 3s
        setTimeout(() => {
            toastContainer.remove();
        }, 3000);
    }

    // /////////
    // Events //
    // /////////
    canvas.addEventListener('mousedown', mouse_down);
    canvas.addEventListener('mouseup', mouse_up);
    canvas.addEventListener('mousemove', mouse_move);
    btn_clear_signature.addEventListener('click', remove_and_clear_signature);
    btn_save_signature.addEventListener('click', save_signaure);

});