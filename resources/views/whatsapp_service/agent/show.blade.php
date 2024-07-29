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
            <h5 class="card-title">Description </h5>
            <p class="card-text">{{$Bot->description}}</p>

          </div>

          @php

           echo '<p class="fs-6">'.$Bot->logicResponses.'</p>';

           $count_l = 0;

          @endphp

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
                  <strong> trigger-key : {{$Lresponses->key_trigger}} -</strong>
                  
                     response of trigger-key : {{ $Lresponses->response}} <code>date create : {{ $Lresponses->created_at}}</code>,
                </div>
              </div>
            </div>
       
        

          @endforeach
      </div> <!-- ACCORDION END -->
        </div>
  </div>

</div>


</x-admindashboard>