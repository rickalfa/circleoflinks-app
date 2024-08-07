
import './requestajax.js';
import {responseAjaxClient } from './responsesrequest.js';
import { hellojson } from './requestajax.js';
import { hellojsonGet } from './requestajax.js';


const url = window.location.origin;





// Con esta funcion averiguamos si la app esta en local o en Produccion

function isLocalhost() {
    return window.location.hostname === "localhost" || 
           window.location.hostname === "127.0.0.1" || 
           window.location.hostname === "";
}


const localpath = isLocalhost() ? "/circleoflinks-app/public" : "/";


/// Form register 
let FormRegister = document.getElementById('formregister');


if (FormRegister  != null) {

    FormRegister.addEventListener('submit', registerUser);

    console.log(" formulario register Done");

    
} else {
    console.log(" formulario register Fail");

}


/// FORM  Login

let FormLogin = document.getElementById('formlogin');


if (FormLogin != null) 
{
    
    FormLogin.addEventListener('submit', loginUser);

    console.log(" Formulario Login DONE codigo de obetener la URL : ");

    
    console.log(url);



}else{


    console.log(" Formulario Login FAIL");




}



// Asegúrate de que el DOM esté completamente cargado antes de agregar el evento
//document.addEventListener('DOMContentLoaded', function() {
//    document.getElementById('btmodal').addEventListener('click', function() {
//        showChatLead(count);
//    });
//});

/////////////////////////////////////////////////////////////
// BUTTON MODAL SHOW CHATLEAD





document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los botones con la clase 'btn'
    const buttons = document.querySelectorAll('button.btn');

    // Iterar sobre los botones y agregarles el evento click
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            console.log('El valor del botón es:', value);

            showChatLead(value);

            // Aquí puedes agregar el código adicional que necesites ejecutar
        });
    });
});


    
    
    function showChatLead(id) {
        // Obtener el valor del input usando el identificador dinámico
        
       

        console.log("El valor del id del Lead : "+ id);

        hellojsonGet(url+localpath+"/component/chatlead/"+id, showchat);
        ///        
    

        // Aquí puedes agregar el código adicional que necesites ejecutar
    }




    
    /////   document.addEventListener('DOMContentLoaded', function() {
///        document.getElementById('btmodal').addEventListener('click', showChatLead);
///    });///

///    function showChatLead()
///    {
///    
///    
///        hellojsonGet(url+localpath+"/component/chatlead/1", showchat);
///        console.log("El evento onclick se ha activado.");
///    
///    
///    
///     }


 function showchat(dates)
 {

    let idshowchat = document.getElementById('chatwsplead');

    idshowchat.innerHTML = dates;

 }




//// REGSITER USER
function registerUser(e){

    e.preventDefault();


    let formRegister = document.getElementById('formregister');

    const dates = {};
    let count = 0;
    let senddates = "";

    for(const elemtform of formRegister.elements){

        dates[elemtform.name] = elemtform.value;


      
        count++;

        console.log(count);


    }

   
    senddates = "_token="+dates['_token']+"&name="+dates['name']+"&email="+dates['email']+"&password="+dates['password']+"&password_confirmation="+dates['password_confirmation'];

    console.log(senddates);

   hellojson(url+localpath+'/register',senddates,responseAjax);


}

function responseAjax(dates){

    let messageelement = document.getElementById('messageresponse');

    let datesre = JSON.parse(dates);

    console.log(datesre.success);

    if (datesre.success) {

        messageelement.innerHTML =   '<div class="alert alert-success alert-dismissible">'+
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'+
                                    '<strong>Success!</strong> usuario registrado.</div>';

        recargarPaginaEnSegundos(2000);
        
    }else{
     
        messageelement.innerHTML =  '<div class="alert alert-danger alert-dismissible">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'+
        '<strong>Danger! </strong>'+ datesre.massage +'.</div>'
    }

   

}




//LOGIN Request


function loginUser(e){

    e.preventDefault();

    let formLogin = document.getElementById('formlogin');

    const dates = {};
    let count = 0;
    let senddates = "";

    for(const elemtform of formLogin.elements){

        dates[elemtform.name] = elemtform.value;


    }


    senddates = "_token="+dates['_token']+"&email="+dates['email']+"&password="+dates['password'];
     

    console.log(" datos enviar : " + senddates + "/n");

  

    hellojson(url+localpath+'/login', senddates, responseAjaxClient);






}

function recargarPagina() {
    location.reload();
  
}


function recargarPaginaEnSegundos(milisegundos) {
    setTimeout(recargarPagina, milisegundos); // 2 segundos en milisegundos




}
