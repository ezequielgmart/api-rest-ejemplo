
const listaPacientes = () => {
    
    const url_get = '../pacientes.php'; // Ruta para traer la lista de pacientes
    fetch(url_get,{
        method:'GET',
        headers:{
            'token':localStorage.getItem('tk_auth')
        }
        
    })
    .then(res => res.json())
    .then(data =>{
        console.log(data)
    }) 
    
}