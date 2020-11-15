if (localStorage.getItem('user') && localStorage.getItem('tk_auth')) {
    fetch('../validar.php',{
        method:'POST',
        body:JSON.stringify({'token':localStorage.getItem('tk_auth')})
    })
    .then(res => res.json())
    .then(data=>{
        switch (data.codigo) {
            case data.codigo = "200":
                break;
            
            case data.codigo = "400":
                location.href = 'index.html'
                break;
            
            default:
                break;
        }
    })
} else {
    location.href = 'index.html'

}