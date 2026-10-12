<x-admindashboard>



   
<div class="container">

  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/admindashboard')}}">Dashboardadmin</a></li>
    <li class="breadcrumb-item"><a href="{{route('/admindashboard/bots-r')}}">Bots-r</a></li>
    <li class="breadcrumb-item active" aria-current="page">Details</li>
  </ol>
</nav>


  <div class="row">
    <div class="col-2 m-2">
     <h4> Details Bot-R</h4>
    </div>
  </div>

  <div class="row">
        <div class="card text-white bg-dark mb-3 fs-4" style="width: 100%;">
          <div class="card-header"><i class="bi bi-robot" style="font-size: 2rem; color: rgb(252, 249, 54);"></i>  Name : {{ $Bot->name}}
          
            <h6> Version Bot : {{$Bot->version}}</h6>

            <h6> Status Bot : {{$Bot->status}}</h6>
          

          </div>
          <div class="card-body">
            <h5 class="card-title">Description</h5>
            <p class="card-text">{{$Bot->description}}</p>

            <hr class="border-secondary">

            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title mb-0">
                <i class="bi bi-stars text-warning me-2"></i>Motor de Inteligencia Artificial (IA)
              </h5>
              @if($Bot->ai_enabled)
                <span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i>IA Habilitada ({{ $Bot->ai_provider }})</span>
              @else
                <span class="badge bg-secondary fs-6"><i class="bi bi-dash-circle me-1"></i>IA Desactivada</span>
              @endif
            </div>

            @if($Bot->ai_enabled)
              <div class="bg-black bg-opacity-25 rounded p-3 small mb-3">
                <div class="row g-2">
                  <div class="col-md-4">
                    <strong>Personaje:</strong> <span class="text-info">{{ $Bot->persona_name ?: 'Sin definir' }}</span>
                  </div>
                  <div class="col-md-4">
                    <strong>Rol:</strong> <span>{{ $Bot->role ?: 'Sin definir' }}</span>
                  </div>
                  <div class="col-md-4">
                    <strong>Tono:</strong> <span class="badge bg-primary-subtle text-primary">{{ $Bot->tone ?: 'cercano' }}</span>
                  </div>
                  @if($Bot->knowledge_base)
                    <div class="col-12 mt-2">
                      <strong>Base de Conocimiento:</strong>
                      <div class="p-2 bg-dark rounded border border-secondary mt-1 font-monospace" style="white-space: pre-wrap; max-height: 150px; overflow-y: auto;">{{ $Bot->knowledge_base }}</div>
                    </div>
                  @endif
                </div>
              </div>
            @endif
          </div>

          <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
           Logic_responses Json Format :
          </button>

          <div class="collapse m-2" id="collapseExample">
            <div class="card text-white bg-dark card-body">
            
              @php

              echo '<p class="fs-6"> <code>'.$Bot->logicResponses.'</code> </p>';

              $count_l = 0;

              @endphp

            </div>
          </div>

      <div class="row">
        <div class="col-2 m-2">
          <a class="btn btn-primary" href="{{route('logic_responses.create', $Bot->id)}}" rel="noopener noreferrer"> 
            Create Logic response
            <i class="bi bi-plus-circle" style="font-size: 1.1rem"></i>
          </a>
        
        </div>
      </div>


 <div class="accordion p-2 m-1" id="accordionExample"> <!-- ACCORDION START -->
          @foreach($Bot->logicResponses as $Lresponses)

          @php

          $count_l++;

          @endphp
        
        
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{$count_l}}" aria-expanded="false" aria-controls="collapseTwo">
                   <div class="d-flex flex-row bd-highlight mb-1">
                        <div>      
                          <i class="bi bi-node-plus" style="font-size: 1.6rem; color:darkorange"></i>
                        </div>
                        <div class="px-3">  
                          #{{$count_l}}  Logic response  Name : {{$Lresponses->name}}
                        </div> 
                   </div>
                </button>
              </h2>
              <div id="collapseTwo{{$count_l}}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <strong> trigger-key : <span class="badge text-bg-success"> {{$Lresponses->key_trigger}} </span></strong>
                    </li> 
                    <li class="list-group-item">
                      <strong> response of trigger-key : </strong> {{ $Lresponses->response}} 
                    </li>  
                    <li class="list-group-item">
                        <code>date create : {{ $Lresponses->created_at}}</code>
                    </li>   
                  </ul>
                
                   
                   
                </div>
              </div>
            </div>
       
        

          @endforeach
      </div> <!-- ACCORDION END -->
        </div>
  </div>

</div>


</x-admindashboard>