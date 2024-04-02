
import './requestajax.js';
import { hellojson } from './requestajax.js';


let FormRegister = document.getElementById('formregister');

if (FormRegister  != null) {

    FormRegister.addEventListener('submit', registerUser);

    console.log(" formulario register Done");

    
} else {
    console.log(" formulario register Fail");

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

   hellojson('http://localhost/circleoflinks-app/public/register',senddates,responseAjax);


}

function responseAjax(dates){

    let messageelement = document.getElementById('messageresponse');

    let datesre = JSON.parse(dates);

    console.log(datesre.success);

    if (datesre.success) {

        messageelement.innerHTML =   '<div class="alert alert-success alert-dismissible">'+
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'+
                                    '<strong>Success!</strong> usuario registrado.</div>';
        
    }else{
     
        messageelement.innerHTML =  '<div class="alert alert-danger alert-dismissible">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'+
        '<strong>Danger! </strong>'+ datesre.massage +'.</div>'
    }

}
