
let statebtn = true;




const componente = document.getElementById('navebar');
const buttonnav = document.getElementById('buttonnav');


if (componente != null) {

      console.log(" componente navebar encontrado");
  
    
}else{

       console.log(" componente navebar NO encontrado");
  
}


if (buttonnav != null) {

    buttonnav.onclick = changestylenav;


    
}

window.onscroll = function() {scrollnav()};




function scrollnav() {
    const scrollTop = document.documentElement.scrollTop;
    const opacity = scrollTop / 500; // Ajustar según la altura del componente
    
    const componente = document.getElementById('navebar');

    if (opacity < 1 && componente != null) {



        
        componente.style.backgroundColor = `rgba(3, 119, 228, ${opacity})`;
          

    }else{

    
    }

   
    console.log(" scrooll date : "+ opacity);
  
  }




  /**
   * cambio de fondo al pulsar boton de navbar en tamaño pequeño
   */
function changestylenav(){

   let dropnav = document.getElementById("dropmenunav");

   const componente = document.getElementById('navebar');



    if (statebtn && componente != null && dropnav != null) {
        
        dropnav.classList.remove("dropstart");
        dropnav.classList.add("dropdown");

        componente.classList.remove("backopa");
        componente.classList.add("navbar-dark");
        componente.classList.add("bg-primary");
        
    
       
   
        console.log("click button navs");

        statebtn = false

        console.log("click button navs");

    }else{


       const componente = document.getElementById('navebar');

         if (componente != null) {
             componente.classList.remove("bg-primary");
     
      
            
         }
       

        statebtn = true;


    }

   


}