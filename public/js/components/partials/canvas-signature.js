document.addEventListener('DOMContentLoaded', () => {

    // Button submit
    let button_submit_material_assignment = document.getElementById('button_submit_material_assignment');
    // Button clear
    let btn_clear_signature = document.getElementById('btn_clear_signature');

    // Canvas
    let canvas = document.getElementById('signature_professional_canvas');
    let context = canvas.getContext('2d');
    
    // Border and background
    context.strokeStyle = "#555";
    context.lineWidth = 2;
    context.strokeRect(1, 1, 199, 199);

    context.fillStyle = "#EEE";
    context.fillRect(2, 2, 196, 196);

    // Vars
    let drawing = false;
    let lastX = 0;
    let lastY = 0;

    // Functions
    function mouse_down(e){
        drawing = true;
        context.strokeStyle = "#005BAC";
        lastX = e.offsetX;
        lastY = e.offsetY;
    }
    
    function mouse_up(){
        drawing = false;
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
        fetch_signature_null();
    }

    // Update signature on DB (Clear o update)
    function fetch_signature_null() {
        
    }

    // Events
    canvas.addEventListener('mousedown', mouse_down);
    canvas.addEventListener('mouseup', mouse_up);
    canvas.addEventListener('mousemove', mouse_move);

    // Button clear
    btn_clear_signature.addEventListener('click', remove_and_clear_signature);

});