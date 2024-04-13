


export function responseAjaxClient(dates){

    let id_element = "messageresponselogin";

    let messageelement = document.getElementById(id_element);

    let datesre = JSON.parse(dates);

    console.log(datesre.success);

    if (datesre.success) {

        messageelement.innerHTML =   '<div class="alert alert-success alert-dismissible">'+
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'+
                                    '<strong>Success!</strong> Login.</div>';

                                    
    recargarPaginaEnSegundos(2000);

        
    }else{
     
        messageelement.innerHTML =  '<div class="alert alert-danger alert-dismissible">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'+
        '<strong>Danger! </strong>'+ datesre.massagge +'.</div>'
    }

}



function recargarPagina() {
    location.reload();
  
}


function recargarPaginaEnSegundos(milisegundos) {
    setTimeout(recargarPagina, milisegundos); // 2 segundos en milisegundos




}