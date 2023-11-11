# **Harmony Hub API**

### - Descripcion
Esta API tiene como proposito acceder a los datos (canciones y albums) presentes en la BBDD. Todas las respuestas de la API tienen el siguiente formato:
```json
{
	"data": "respuesta del endpoint",
	"status": "Estados de la respuesta"
}
```
Aclaraciones: 

- Los unicos valores posibles de "status" son "success" y "error".

- Ante cualquier error encontrado, todos las respuestas tendran el siguiente formato:
    ```json
    {
        "data": "Mensaje del error",
        "status": "error"
    }
    ``` 

La direccion base de la API es la siguiente:

- **{ruta_serividor_apache}/api**

------------


### - Requerimientos
Contar con la BBDD descripta en el siguiente archivo:
link de la base de datos

------------

### - Endpoints
- #### Paramemtros de ordenamiento:
    Al solicitar una lista de entidades (ver GET: /albums y GET: /songs) podemos usar los siguientes query params para controlar como se muestra la lista incluida en en altributo "data" de la respuesta:

    - **?sort_by** : Este parametro recibe un string que debe corresponder con uno de los campos de la entidad solicitada. (De no corresponder se enviara la respuesta ordenada por el campo por defecto).

    - **?order** : Este parametro recibe un numero entero que puede ser 1 o 0. Si es 1 se ordenara la lista de manera descendiente. De ser 0 o cualquier otro numero se ordenara ascendentemente.
    
- #### Albums

    Cada album se listara de la siguiente manera:
            
    ```json
        {
            "id": 43,
            "title": "Album",
            "img_url": "url_album_cover",
            "rel_date": "2022-12-18",
            "review": "Review",
            "artist": "Artista",
            "genre": "Genero",
            "rating": 4.3 //Numero de tipo float
        }
    ```
    #####  - GET: /albums
    - Este Endpoint devuelve la lista de albums de la base de datos dentro de "data". Puede recibir distintas opciones para filtrar la lista a traves de query params:
    
        - **?search_input** :
        Este paramentro recibe un string y devuelve una lista con todos los albums que lo contengan dentro del titulo.

        - **?min_rating** :
        Este parametro recibe un numero de tipo float y devuelve una lista con todos los albums que tengan un rating mayor al indicado.

    ##### - GET: /albums/:ID
    - Este Endpoint devuelve el album con el ID indicado dentro de "data".

    ##### - POST: /albums
    - Este endpoint recibe un objeto JSON en el body del HTTP Request del siguiente formato:

        ```json
        /*
        Los unicos campos necesarios para añadir o
        modificar un album son "title", "artist", "rating"
        */
        {
            "title": "Album",
            "img_url": "url_album_cover",
            "rel_date": "2022-12-18",
            "review": "Review",
            "artist": "Artista",
            "genre": "Genero",
            "rating": 4.3 //Numero de tipo float
        }
        ```
        La respuesta incluira en "data" el album agregado en el formato antes mostrado (Que incluye el ID asignado).

    ##### - PUT: /albums/:ID
    - Este endpoint recibe un objeto igual al anterior en el body y modifica el elemento con el ID dado en la base de datos.

- #### Autorizacion
    #####  - POST: /auth 
    -  Este Endpoint recibe en el body del request un objeto de tipo JSON con las propiedades "name" y "password'. De ser correctos los datos introducidos, se proporcionara dentro de "data" un token que permite identificarse.
    
   - Ejemplo:
    
        ```json
            //Objeto a incluir en el body del HTTP Request
            {
                "name": "nombre_de_usuario",
                "password": "password"
            }
            
            //Ejemplo de la respuesta
            {
                "data": "token generado",
                "status": "success"
            }
        ```
    - El token generado mediante este endpoint sera requerido para todos los request de tipo POST, PUT, o DELETE de las entidades de datos. Debera agregarse a los Headers del request en el siguiente 
    formato
    
            Autorization: Bearer <Token generado>   