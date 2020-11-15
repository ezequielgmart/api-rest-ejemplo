const btn_close = document.getElementById('cerrarSesion')

btn_close.addEventListener('click', (e)=>{
    e.preventDefault()

    fetch("../desactivar.php", {
        method:'POST',
        body:JSON.stringify({'token':localStorage.getItem('tk_auth')})
    })
    .then(res => res.json())
    .then(data=>{
        localStorage.removeItem('user')
        localStorage.removeItem('tk_auth')
        location.href = 'index.html'
    })
    
})