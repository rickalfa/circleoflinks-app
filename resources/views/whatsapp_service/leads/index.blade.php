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
                                                     <button data-value="{{$Lead->id}}" 
                                                             data-name="{{$Lead->name}}" 
                                                             data-phone="{{$Lead->phone_number}}" 
                                                             data-avatar="{{$link_img}}" 
                                                             type="button" 
                                                             class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" 
                                                             data-bs-toggle="modal" 
                                                             data-bs-target="#staticBackdrop">
                                                        <i class="bi bi-chat-dots-fill me-1"></i> Chat Live
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
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content overflow-hidden border-0 shadow-lg">
        <div class="modal-body p-0">
          <!-- Aquí inyectamos el componente Blade con la UI TypeScript -->
          @include('components.chat-leads', ['Lead' => new \App\Models\WhatsappApi\Lead()])
        </div>
        <div class="modal-footer bg-light py-2">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-lg me-1"></i> Cerrar Chat
          </button>
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

    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            // Botón que activó el modal
            const button = event.relatedTarget;
            if (!button) return;

            // Extraer info de atributos data-*
            const leadId = button.getAttribute('data-value');
            const leadName = button.getAttribute('data-name') || '';
            const leadPhone = button.getAttribute('data-phone') || '';
            const leadAvatar = button.getAttribute('data-avatar') || '';
            
            console.log("Abriendo modal para Lead ID:", leadId, { leadName, leadPhone, leadAvatar });

            // Asignar el lead id al wrapper para que TypeScript lo sepa
            const wrapper = document.getElementById('wspservice-chat-wrapper');
            if (wrapper) {
                wrapper.setAttribute('data-lead-id', leadId);
                
                // Disparar evento personalizado que escucha index.ts
                const eventToDispatch = new CustomEvent('InitLiveChat', { 
                    detail: { 
                        leadId: Number(leadId),
                        name: leadName,
                        phone: leadPhone,
                        avatar: leadAvatar
                    } 
                });
                document.dispatchEvent(eventToDispatch);
            }
        });

        modal.addEventListener('hidden.bs.modal', function () {
            // Cuando se cierra el modal, enviar evento para destruir el polling
            const eventToDispatch = new CustomEvent('DestroyLiveChat');
            document.dispatchEvent(eventToDispatch);
            
            // Limpiar contenedor de mensajes
            const container = document.getElementById('chat-messages-container');
            if (container) {
                container.innerHTML = '<div class="text-center text-muted my-auto"><div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div><small>Cargando mensajes...</small></div>';
            }
        });
    }
});
</script>

</x-admindashboard>