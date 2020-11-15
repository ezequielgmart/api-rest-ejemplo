# Tipos de autenticacion para una api rest
1. *Auteticacion basica*
Cada vez que el lenguaje de front end hace una peticion a la api REST, dicho lenguaje envia su usuario y contraseña, lo cual puede ocasionar una brecha de seguridad llamada como Man in the Middle. Esto quiere decir que de interceptarse el paquete con dicha informacion, el tercero podría hacerse con el usuario y contraseña.
2. *token*
El lenguaje del frontend envia una sola vez el usuario y contraseña a la api REST y este le devuelve un token, y con este token hara todas las solicitudes. 
El usuario envia los datos de login, el api le devuelve un OK , y luego los accesos solo se envia el token.
los token están codificados con la fecha. Se puede configurar para que caduque después de un tiempo definido.
3. *Api-key*
A diferencia de los dos metodos anteriores, en este caso primero se configura el acceso a los recursos. Este acceso siempre esta validado con un key, solo que los api-key no tienen tiempo de caducidad. El usuario en caso de detectar un problema con dicho api-key, podría crear otro y dar de baja al anterior. 
4. *oAuth 2.0 (Autenticacion abierta)*
Es un metodo de autorizacion utilizado por compañias como google, facebook etc. Su proposito es permirtir a otros proveedores, servicios o aplicaciones, el acceso a la informaciion sin facilitar directamente las credenciales de los usuarios. 
5. *file_get_contents('php://input')*
https://es.stackoverflow.com/questions/294029/para-que-sirve-file-get-contentsphp-input