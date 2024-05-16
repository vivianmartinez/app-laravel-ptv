window.addEventListener('load',()=>{
    const iniCanvas = document.getElementById('canvas');
    let iniDataUrl;
    if(iniCanvas !== null){
        iniDataUrl = iniCanvas.toDataURL(); // canvas sin firma
    }

    const form = document.getElementById('form-user');

    if(form !== null){

        //Enviamos los datos del formulario
        const sendFormData = async()=>{
            const canvas = document.getElementById('canvas');
            //obtenemos el dataurl del canvas
            const dataURL = canvas.toDataURL('image/png');

            //datos del formulario
            const token = document.getElementsByName('_token')[0].value;
            const name_user = document.getElementById("name");
            const email = document.getElementById("email");
            const data_user = document.getElementById("data-user");
            const dni = data_user.getAttribute('data-dni');
            const code_user = data_user.getAttribute('data-code');

            //validar nombre y correo válido
            let regx = /^[A-Za-zñÑáéíóúÁÉÍÓÚ\d\s]+$/;
            let regxmail = /^[a-zA-Z\d._-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,6}$/;
            let isError = false;

            //validar que firme
            if(iniDataUrl === dataURL){
                createMessage('message-error','Debe firmar.');
                isError = true;
            }
            //validamos el formulario
            if(!regx.test(name_user.value)){
                createMessage('message-error','Nombre no válido.');
                isError = true;
            }
            // validar email
            if(!regxmail.test(email.value)){
                createMessage('message-error','Email no válido.');
                isError = true;
            }
            //validar datos del endpoint en caso que los modifiquen en el front
            if(! /^[A-Za-z\d]+$/.test(dni) || ! /^[A-Za-z\d]+$/.test(code_user)){
                createMessage('message-error','Datos inválidos.');
                isError = true;
            }

            if(!isError){
                const dataForm = {
                    'token': token,
                    'name': name_user.value,
                    'email': email.value,
                    'dni': dni,
                    'code_user': code_user,
                    'dataurl_canvas': dataURL
                }

                try{
                    const send = await fetch("\submit",{
                        headers: {"X-CSRF-TOKEN":token, "Content-Type":"application/json"},
                        method: 'POST',
                        processData: false,
                        cache: 'no-cache',
                        credentials: "same-origin",
                        referrerPolicy: "no-referrer",
                        body: JSON.stringify(dataForm)
                    })
                    .then(response => response.json())
                    .then(response_submit =>{
                        //Mostrar mensaje al usuario
                        if(response_submit.error)
                            createMessage('message-error',response_submit.message);
                        else{
                            createMessage('message-success',response_submit.message);
                        }

                        //limpiar formulario
                        name_user.value = "";
                        email.value = "";
                        if(canvas.getContext){
                            const ctx = canvas.getContext('2d');
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                        }

                    });

                }catch(error){
                    console.log(error);
                }
            }
        }


        form.addEventListener('submit',(e)=>{
            e.preventDefault();
            sendFormData();
        });
    }

    const removeMessage = ()=>{
        setTimeout(()=>{
        const msgError = document.getElementsByClassName('message-error');
            while(msgError.length > 0){
                msgError[0].parentNode.removeChild(msgError[0]);
            }
        },3000);
    }

    const createMessage = (nameClass,message) =>{
        const p = document.createElement('p');
        p.classList.add(nameClass);
        p.innerText = message;
        const messageForm =  document.getElementById("message-form");
        messageForm.appendChild(p);
        removeMessage();
    }

});

