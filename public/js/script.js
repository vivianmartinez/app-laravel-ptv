window.addEventListener("load",function(){

    const canvas = document.getElementById('canvas');
    const btnClear = document.getElementById('btn-clear');

    let cdX;
    let cdY;

    if(canvas !== null){
        canvas.addEventListener('touchstart', touchDown, false);
        canvas.addEventListener('touchend', up, false);
        canvas.addEventListener('mousedown', touchDown);
        canvas.addEventListener('mouseup',up);
        btnClear.addEventListener('click', clearCanvas);
    }

    const getPosTouch = (e) => {
        const touch = e.changedTouches[0];
        const rect = canvas.getBoundingClientRect();
        return {
            x: touch.clientX - rect.left,
            y: touch.clientY - rect.top,
        };
    }

    function draw(x, y) {
        if(canvas.getContext){
            const ctx = canvas.getContext('2d');
            ctx.strokeStyle = 'black';
            ctx.beginPath();
            ctx.moveTo(cdX, cdY);
            ctx.lineWidth = 2;
            ctx.lineTo(x, y);
            ctx.lineCap = "round";
            ctx.lineJoin = "round";
            ctx.closePath();
            ctx.stroke();
            cdX = x;
            cdY = y;
        }
    }

    function touchDown(e) {
        cdX = e.offsetX;
        cdY = e.offsetY;
        draw(cdX,cdY);
        if(e.type == "touchstart")
            canvas.addEventListener('touchmove', touchMove, {passive: true});
        else
            canvas.addEventListener('mousemove', touchMove, {passive: true});

    }

    function touchMove(e) {
        if(e.type == "touchmove"){
            const pos = getPosTouch(e);
            draw(pos.x, pos.y);
        }else{
            draw(e.offsetX,e.offsetY);
        }
    }

    //cuando suelta el click o deja de tocar el dispositivo
    function up() {
        canvas.removeEventListener('touchmove',touchMove);
        canvas.removeEventListener('mousemove',touchMove);
    }
    //limpiar canvas
    function clearCanvas(){
        if(canvas.getContext){
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    }
});
