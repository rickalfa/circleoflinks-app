
let statebtn = true;




const componente = document.getElementById("navebar");
const buttonnav = document.getElementById("buttonnav");

if (componente) {
    console.log("componente navebar encontrado");
} else {
    console.log("componente navebar NO encontrado");
}

if (buttonnav) {
    buttonnav.onclick = changestylenav;
}

window.addEventListener("scroll", scrollnav);

function scrollnav() {

    const scrollTop = document.documentElement.scrollTop;

    let opacity = scrollTop / 500;

    // limitar entre 0 y 1
    if (opacity > 1) opacity = 1;

    if (componente) {
        componente.style.backgroundColor = `rgba(3,119,228,${opacity})`;
    }

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