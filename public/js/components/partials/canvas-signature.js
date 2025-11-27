document.addEventListener('DOMContentLoaded', () => {

    // Button submit
    let button_submit_material_assignment = document.getElementById('button_submit_material_assignment');

    // Canvas
    let canvas = document.getElementById('signature_professional_canvas');
    let context = canvas.getContext('2d');
    
    // Border and background
    context.strokeStyle = "black";
    context.lineWidth = 2;
    context.strokeRect(1, 1, 199, 199);

    context.fillStyle = "white";
    context.fillRect(2, 2, 196, 196);

    // Vars
    let drawing = false;
    let lastX = 0;
    let lastY = 0;

    // Functions
    function mouse_down(e){
        drawing = true;
        lastX = e.offsetX;
        lastY = e.offsetY;
    }
    
    function mouse_up(){
        drawing = false;
    }
    
    function mouse_move(e){
        if(drawing){
            button_submit_material_assignment.disabled = false;
            context.beginPath();
            context.moveTo(lastX, lastY);
            context.lineTo(e.offsetX, e.offsetY);
            context.stroke();

            lastX = e.offsetX;
            lastY = e.offsetY;
        }
    }

    // Events
    canvas.addEventListener('mousedown', mouse_down);
    canvas.addEventListener('mouseup', mouse_up);
    canvas.addEventListener('mousemove', mouse_move);

});