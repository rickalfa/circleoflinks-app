<x-admindashboard>



<div class="container-fluid">
    
    <div class="row">
        
        <div class="col-lg-12">

            <div>
                <table class="table table-dark table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Leads</th>
                            <th scope="col">Contacto </th>
                            <th scope="col">Handle</th>
                          </tr>
                    </thead>
                    <tbody>
           
             @php

              $count = 0;


             @endphp
<!------------------ START FOR LEADS ------------------------------>
                 @foreach($Leads as $Lead)

                
                      @php

                       $count++;
                       
                      $link_img = "https://mdbootstrap.com/img/Photos/Avatars/avatar-".$count.".jpg";

                      @endphp

                      <tr >
                        <th>

                        </th>
                        <th  class="table-active fs-6"  style="width: 19rem; height: 5rem">
                      
                               
                                    <div class="card" >
                                        <div class="card-header">
                                            <div class="d-flex flex-column"> 
                                                <div class="d-flex justify-content-start">
                                                    <div> 
                                                        <img src={{$link_img}} class="rounded-circle me-3" height="50px"
                                                        width="50px" alt="avatar" />  

                                                    </div>
                                                    <div class="px-2">
                                                        <i class="bi bi-whatsapp" style="color: green"> </i>
                                                    </div>
                                                    <div>
                                                        <p>   {{$Lead->name}}</p>

                                                    </div>
                                                 
                                                </div>
                                                <div class="d-flex justify-content-end">
                                              
                                                    <p class="card-text" style="font-size: 10px"><i class="far fa-clock pe-2"></i>ultimo mensaje : {{$Lead->last_message_time}}</p>
                                                 </div>
                                            </div>
                                     </div>
                                    
                                                    
                                            <div class="p-1 d-flex justify-content-center">

                                                
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">+ {{$Lead->phone_number}}</li>
                                               
                                                </ul>
                                                    <!-- Button trigger modal -->
                                                     <button  data-value={{$Lead->id}}  id="btmodal"  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">

                                                        chat Live 

                                                        <input type="hidden" id="phone_number_"{{$count}} value={{$Lead->id}}>

                                                     </button>
                                               
                                            </div>
                                   </div>
   
                          
                              
                        </th>
                        <th></th>
                        <th></th>
                      </tr>

                  @endforeach   
<!------------------ END FOR LEADS ------------------------------>
                    </tbody>
                  </table>
                  


            </div>


        </div>
<!-- Modal -->
<div style="height: width:80wv;" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content" >
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
          <!-- Aquí inyectamos el componente Blade que ahora contiene la UI TypeScript -->
          @include('components.chat-leads', ['Lead' => new \App\Models\WhatsappApi\Lead()])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

    </div>
</div>

<!-- Lógica para abrir el chat al hacer clic en el botón -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('staticBackdrop');
    let chatManagerInstance = null; // Guardará la instancia del ChatManager

    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            // Botón que activó el modal
            const button = event.relatedTarget;
            // Extraer info de atributos data-* (data-value tiene el lead id)
            const leadId = button.getAttribute('data-value');
            
            console.log("Abriendo modal para Lead ID:", leadId);

            // Asignar el lead id al wrapper para que TypeScript lo sepa
            const wrapper = document.getElementById('wspservice-chat-wrapper');
            if (wrapper) {
                wrapper.setAttribute('data-lead-id', leadId);
                
                // Limpiar instancia previa si existe (evita múltiples pollings)
                if (chatManagerInstance) {
                    chatManagerInstance.destroy();
                }

                // Disparar un evento personalizado que escuche index.ts
                // o instanciar ChatManager directamente si lo exponemos al window.
                // Como lo importamos por Vite, la mejor forma es un CustomEvent
                const eventToDispatch = new CustomEvent('InitLiveChat', { detail: { leadId: Number(leadId) } });
                document.dispatchEvent(eventToDispatch);
            }
        });

        modal.addEventListener('hidden.bs.modal', function () {
            // Cuando se cierra el modal, enviar evento para destruir el polling
            const eventToDispatch = new CustomEvent('DestroyLiveChat');
            document.dispatchEvent(eventToDispatch);
            
            // Limpiar contenedor de mensajes
            const container = document.getElementById('chat-messages-container');
            if (container) container.innerHTML = '<div class="text-center text-muted mt-3"><small>Cargando mensajes...</small></div>';
        });
    }
});
</script>

</x-admindashboard>