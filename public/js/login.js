const url_login = "../auth"
const form = document.getElementById('form')
const error_div = document.getElementById('error')

form.addEventListener("submit", (e)=>{
    e.preventDefault()

    const formData = new FormData(form)

    fetch(url_login,{
        method: 'POST',
        body:formData
       
        
    })
    .then(res => res.json())
    .then(data =>{

        if (data.status == 'ok') {
            localStorage.setItem('user',formData.get('usuario'))
            localStorage.setItem('tk_auth',data.result.token)
            window.location.href='home.html'

            
            
        }else{
            switch (data.result.error_id) {
                case data.result.error_id = '200':
                    break; 
                case data.result.error_id = '202':
                    
                    errorAlert("¡Contraseña incorrecta!")
                    break;
                
                case data.result.error_id = '203':                    
                console.log(data)
                   
                    errorAlert("El usuario no existe")
                    break;
            
                default:
                    break;
            }
            
        }
    })  
})

const errorAlert = (contenido) =>{
    limpiarDivError(error_div)
    const fragment = document.createDocumentFragment()

    const card = document.createElement('div')
        card.setAttribute('role', 'alert')
        card.setAttribute('class', 'alert alert-danger')
        card.textContent = contenido

    fragment.append(card)
    error_div.append(fragment)


}

const limpiarDivError = (div) =>{
    if (div.children[0]) {
        div.removeChild(div.children[0])
    }
    
}