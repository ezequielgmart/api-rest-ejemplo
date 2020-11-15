{/* <script>


// let v = 2
// if (v == 1) {
    
// window.location.href = "http://www.google.com";
// }
    const main = document.getElementById('main')
    const usuario = "ezequiel guzman"
    const edad = 23
    // const token = 'a'

    fetch('../validar.php',{
        method:'POST',
        headers:{
            nombre: usuario,
            edad: edad,
            correo: correo,
            autenticacion: token
            
        },
        // body:{
        //     "token":token
        // }
        body: JSON.stringify({autenticacion: token}) 
    })
    .then(res => res.json())
    .then(data =>{
        if (data.codigo == 200) {
            
            insertarParrafo(`Acceso concedido para ${usuario}`)
        } else {
            insertarParrafo("Acceso denegado")
        }
        // console.log(data)
    })

    const insertarParrafo = (contenido) =>{
        const div = document.createElement('div')
        const p = document.createElement('p')
        p.textContent = contenido
        div.appendChild(p)
        main.appendChild(div)

    }
</script> */}