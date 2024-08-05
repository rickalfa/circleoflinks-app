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
                                                     <button id="btmodal" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                        chat Live 
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
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="chatwsplead">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div>

    </div>

</div>













</x-admindashboard>