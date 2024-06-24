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
         
                      



                  
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="card mb-4">
                            <div class="card-body text-center">
                              <img src={{ $user->avatar}} alt="avatar"
                                class="rounded-circle img-fluid" style="width: 150px;">
                              <h5 class="my-3">{{ $user->name}}</h5>
                              <p class="text-muted mb-1">Full Stack Developer</p>
                              <p class="text-muted mb-4">Bay Area, San Francisco, CA</p>
                              <div class="d-flex justify-content-center mb-2">
                               <!-- <button type="button" class="btn btn-primary">Follow</button> -->
                               <!-- <button type="button" class="btn btn-outline-primary ms-1">Message</button> -->

                              </div>
                            </div>
                          </div>

                     


                        </div>
                        <div class="col-lg-8">
                          <div class="card mb-4">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $user->name}}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $user->email}}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Phone</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">(097) 234-5678</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Mobile</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">(098) 765-4321</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Address</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $user->address}}</p>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="row">
                        
                           

                          </div>
                        </div>
                      </div>
                    </div>
                  </section>

      
             </div>
         </div>

      </div>

       </div>
     </div>

     <!-- END Container-fluid-->
    </div>
</x-guest-layout>
