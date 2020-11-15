class Usuario{
    constructor(nombre, token){
        this.token = token
        this.nombre = nombre
    }

    datos(){
        return this.nombre
    }
    // saludar(){
    //     return this.nombre
    // }

    
    setToken(token){
        this.token = token
    }
    getNombre(){
        return this.nombre
    }
    getToken(){
        return this.token
    }
}

