const form = document.getElementById('form')
const mensajes = document.getElementById('mensajes')
const span_mensaje = document.getElementById('error')
const container = document.getElementById('div_container')

form.addEventListener('submit', (e)=>{
    e.preventDefault()
    const url_nuevoPaciente = '../pacientes.php'
    const formData = new FormData(form)


    // nuevoPaciente(url_nuevoPaciente,formData)
    fetch(url_nuevoPaciente,{
        method:'POST',
        body:formData,
        headers:{
            'token':localStorage.getItem('tk_auth')
        }
        
    })
    .then(res => res.json())
    .then(data =>{
        
        
        if (data.status == "ok") {
            let mensaje = `paciente ${formData.get('nombre')} ha sido registrado correctamente`
           alert(mensaje)
            listaPacientes()
            form.reset()
        } else {
            // const div = document.createElement('div')
            // div.setAttribute('class','completado')
            // div.setAttribute('data-aos','fade-up-right')
            // mensajes.hidden = false
            setTimeout(console.log("Hola"),5000)
            span_mensaje.textContent = data.result.error_mg
            // div.textContent = data.result.error_mg
            // body.append(div)
            // alert(data.result.error_mg)

        }

    })
    
})
function aparecer(divAgregar){
    const div = document.createElement('div')
    div.setAttribute('class','completado')
    div.setAttribute('data-aos','fade-up-right')
    span_mensaje.textContent = data.result.error_mg

}

function nuevoPaciente(url,formulario) {
    fetch(url,{
        method:'POST',
        body:formulario,
        headers:{
            'token':localStorage.getItem('tk_auth')
        }
        
    })
    .then(res => res.json())
    .then(data =>{
        console.log(data)
        listaPacientes()
    })
}