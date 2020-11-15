# METODOS DE LA CLASE CONEXION.
1. *datosConexion()*
Toma el archivo config, lo lee, y retorna un array con toda la info.  
2. *metodo constructor()*
Guarda dentro de una variable el array que me retornó datosConexion() y lo recorre. 
Luego instancia un objeto msqli el cual recibe por parametro los datos de la conexion.     
3. *convertirUTF8($array)*
Toma todo los elementos que trae de la base de datos y los convertirá a utf-8 para 
4. *obtenerDatos($consulta)*
Obtiene los datos de una consulta que le pasemos por parametro
5. *nonQuery($consulta)*
Regresa 1 si fue una fila afectada o 0 en caso de no serlo. 
6. *nonQueryId($consulta)*
Nos devuelve la cantidad de registros que contiene la tabla

# NOTAS
1. Los metodos protected se pueden utilizar siempre y cuando la clase sea un hijo.