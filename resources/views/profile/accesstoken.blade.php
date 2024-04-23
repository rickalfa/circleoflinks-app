<x-guest-layout>

    <div class="container-fluid">
      <!-- Componente dashboardprofile -->
      <div class="row">

        <div class="col h-25 d-inline-block" >
          <div style="height: 70px;">
       
           <x-profile.dashboardprofile/>

          </div>
        </div>
        
      </div>

     <div class="row">
        <div class="col-lg-3">
          <x-profile.sidebarprofile/>
        </div>
        <div class="col-lg-9">
             <div class="py-12">
                <section style="background-color: #eee;">
                    <div class="container py-5">
                      <div class="row">
                        <div class="col">
                          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                            <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
                              <li class="breadcrumb-item"><a href="#">User</a></li>
                              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                            </ol>
                          </nav>
                        </div>
                      </div>

                      @php
                  
                      $userm = Auth::user();

                      //dd($userm->hasVerifiedEmail());

                ////     if($userm->hasVerifiedEmail()) {
                ////             echo 'La dirección de correo electrónico del usuario ha sido verificada';
                ////         } else {
                ////             echo '  <div class="alert alert-danger alert-dismissible fade show">
                ////             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                ////             <strong>Danger!</strong> Email no verificed . <a href="{{  }}"> verified email </a></div>';
                ////         }

              
                      @endphp



                      @if ($userm->hasVerifiedEmail())

                        <h1> email verificed</h1>

                      @else


                        <div class="alert alert-danger alert-dismissible fade show">
                          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                          <strong>Danger!</strong> Email no verificed . <a href="{{ url('verify-email') }}"> verified email </a></div>


                        @endif
         
                    

      
             </div>
         </div>

      </div>

       </div>
     </div>

     <!-- END Container-fluid-->
    </div>
</x-guest-layout>
