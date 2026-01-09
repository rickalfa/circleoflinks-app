
import './requestajax.js';
import {responseAjaxClient } from './responsesrequest.js';
import { hellojson } from './requestajax.js';

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

    console.log(" Formulario Login DONE");


}else{


    console.log(" Formulario Login FAIL");




}






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

   hellojson('http://localhost/proyectos_composer/circleoflinks-app/public/register',senddates,responseAjax);


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
     

    console.log(" datos enviar : " + senddates);

    hellojson('http://localhost/proyectos_composer/circleoflinks-app/public/login', senddates, responseAjaxClient);






}

function recargarPagina() {
    location.reload();
  
}


function recargarPaginaEnSegundos(milisegundos) {
    setTimeout(recargarPagina, milisegundos); // 2 segundos en milisegundos




}
