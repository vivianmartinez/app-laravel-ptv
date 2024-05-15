window.addEventListener('load',()=>{
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

            const dataForm = {
                'token': token,
                'name': name_user.value,
                'email': email.value,
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
                }).then(response => response.json())
                .then(response_submit =>{

                    //crear elemento en el dom para mostrar un mensaje al usuario
                    console.log(response_submit);
                    const message_div = document.createElement('div');
                    message_div.setAttribute('id','success');
                    const message = document.createElement('p');

                    if(! response_submit.error){
                        message.innerText = response_submit.message;
                    }else{
                        message.innerText = 'Ha ocurrido un error interno. Intentelo más tarde';
                    }

                    message_div.append(message);

                    //limpiar formulario
                    name_user.value = "";
                    email.value = "";
                    if(canvas.getContext){
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                    }
                    //Mostrar mensaje al usuario
                    form.appendChild(message_div);
                })

            }catch(error){
                console.log('error');
            }

        }


        form.addEventListener('submit',(e)=>{
            e.preventDefault();
            sendFormData();
        });
    }
});

