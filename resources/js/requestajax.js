




//Peticion AJAX con metodo POST 

export function hellojson(pathre,senddat,mycallback)
{
    
    let objre = new XMLHttpRequest();

    //PASO  1 nro
    //Algunas versiones de los navegadores Mozilla
    // no funcionan correctamente si la respuesta del servidor no tiene
    // la cabecera mime de tipo XML. En ese caso es posible usar un método
    // extra que sobreescriba la cabecera enviada por el servidor, 
    //en caso que no sea text/xml.
    //objre.overrideMimeType('text/xml');

    //objre.responseType = "json";
               
    //PASO  2 nro
    //Es importante notar que no hay paréntesis después del nombre
    // de la función y no se pasa ningún parámetro. 
    //También es posible definir la función en ese momento,
    // y poner en seguida las acciones que procesarán la respuesta:
    objre.onreadystatechange = function()
    {
        if(objre.readyState == 4)
        {
            if ( objre.status == 200) {

               
               console.log("acceso a archivo :" + pathre);  

             
            }  // con ajax el archivo es puesto como argumento en el metodo Open
            else
            {
                console.log("Error : al retornar el estado de la peticion HELLO jason error 200");
             
            }

        }
     
    }


    //PASO  3 nro
    //Después de especificar qué pasará al recibir la respuesta es
    // necesario hacer la petición. Para esto se utilizan los métodos open() y send()
    // de la clase HTTP request, como se muestra a continuación:
    objre.open('POST',pathre);

    objre.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         
     /// accion que se hace si la Peticion es Exitosa
    objre.onload = function () {
            
        //setdatesreq(objre.responseText);

        //console.log("metodo onload debuelto response text "+ objre.responseText);
        
        let dates = objre.responseText;

        //let datest = JSON.stringify(dates);
        //let datesre = JSON.parse(dates);
        //
        //
        // console.log("datos de respuesta  : " + datesre);
        // console.log(" dato user del obj " + datesre.user);
        console.log(" datos del obj " + dates);

        mycallback(dates);

        
    }


      //El parámetro en el método send()puede ser cualquier
      // información que se quiera enviar al servidor si se usa POST 
      //para la petición. La información se debe enviar en forma de cadena, 
      //por ejemplo: name=value&anothername=othervalue&so=on

 
    objre.send(senddat);

   
}