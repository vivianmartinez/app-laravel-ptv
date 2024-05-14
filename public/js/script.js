window.addEventListener("load",function(){
    console.log('listo');
    const canvas = document.getElementById('canvas');
    const btnClean = document.getElementById('btn-clean');
    const btnSubmit = document.getElementById('btn-submit');
    const imageCanvas = document.getElementById('img-canvas');

    let cdX;
    let cdY;

    canvas.addEventListener('touchstart', touchDown, {passive:true});
    canvas.addEventListener('touchend', up, {passive: true});
    canvas.addEventListener('mousedown', touchDown);
    canvas.addEventListener('mouseup',up);
    btnClean.addEventListener('click', clearCanvas);
    btnSubmit.addEventListener('click', clearCanvas);
    btnSubmit.addEventListener('click', canvasToImage);


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
    //botón limpiar canvas
    function clearCanvas(){
        if(canvas.getContext){
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    }
    //convertir canvas a imagen
    function canvasToImage(){
        const canvaData = canvas.toDataURL("image/jpeg");
        imageCanvas.src = canvaData;
    }

});
